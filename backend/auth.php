<?php
declare(strict_types=1);

require_once __DIR__ . '/db_connect.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

function normalizeRoleCode(string $roleCode): string
{
	$normalized = strtolower(trim($roleCode));

	$roleMap = [
		'head' => 'hc_head',
		'hc_head' => 'hc_head',
		'health_center_head' => 'hc_head',
		'bhw' => 'bhw',
		'bns' => 'bns',
	];

	return $roleMap[$normalized] ?? 'bns';
}

function verifyAndMigratePassword(PDO $pdo, array $user, string $plainPassword): bool
{
	$stored = (string) ($user['password_hash'] ?? '');
	if ($stored === '') {
		return false;
	}

	$verified = false;
	$passwordInfo = password_get_info($stored);
	$isHashed = !empty($passwordInfo['algoName']) && $passwordInfo['algoName'] !== 'unknown';

	if ($isHashed) {
		$verified = password_verify($plainPassword, $stored);
	} else {
		// Support legacy plaintext passwords and upgrade them after successful login.
		$verified = hash_equals($stored, $plainPassword);
		if ($verified) {
			try {
				$newHash = password_hash($plainPassword, PASSWORD_DEFAULT);
				$upgrade = $pdo->prepare('UPDATE users SET password_hash = :password_hash WHERE user_id = :user_id');
				$upgrade->execute([
					'password_hash' => $newHash,
					'user_id' => $user['user_id'],
				]);
			} catch (PDOException $exception) {
				// Login should still proceed even if legacy hash migration is blocked by DB rules.
			}
		}
	}

	if ($verified && $isHashed && password_needs_rehash($stored, PASSWORD_DEFAULT)) {
		try {
			$newHash = password_hash($plainPassword, PASSWORD_DEFAULT);
			$rehash = $pdo->prepare('UPDATE users SET password_hash = :password_hash WHERE user_id = :user_id');
			$rehash->execute([
				'password_hash' => $newHash,
				'user_id' => $user['user_id'],
			]);
		} catch (PDOException $exception) {
			// Non-blocking maintenance update.
		}
	}

	return $verified;
}

function authenticateUser(string $email, string $plainPassword): ?array
{
	$pdo = getDbConnection();

	$query = $pdo->prepare(
		'SELECT
			u.user_id,
			u.first_name,
			u.last_name,
			u.email,
			u.password_hash,
			u.is_active,
			r.role_code,
			r.role_name
		FROM users u
		INNER JOIN roles r ON r.role_id = u.role_id
		WHERE u.email = :email
		LIMIT 1'
	);

	$query->execute(['email' => $email]);
	$user = $query->fetch();

	if (!$user) {
		return null;
	}

	if ((int) $user['is_active'] !== 1) {
		return null;
	}

	if (!verifyAndMigratePassword($pdo, $user, $plainPassword)) {
		return null;
	}

	try {
		$updateLogin = $pdo->prepare('UPDATE users SET last_login = NOW() WHERE user_id = :user_id');
		$updateLogin->execute(['user_id' => $user['user_id']]);
	} catch (PDOException $exception) {
		// Non-blocking metadata update.
	}

	unset($user['password_hash']);

	return $user;
}

function loginUser(array $user): void
{
	$_SESSION['user'] = $user['email'];
	$_SESSION['user_id'] = (int) $user['user_id'];
	$_SESSION['name'] = trim($user['first_name'] . ' ' . $user['last_name']);
	$_SESSION['role'] = normalizeRoleCode((string) $user['role_code']);
	$_SESSION['role_name'] = $user['role_name'];
}

function logoutUser(): void
{
	$_SESSION = [];

	if (ini_get('session.use_cookies')) {
		$params = session_get_cookie_params();
		setcookie(
			session_name(),
			'',
			time() - 42000,
			$params['path'],
			$params['domain'],
			$params['secure'],
			$params['httponly']
		);
	}

	session_destroy();
}
