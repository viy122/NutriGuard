<?php
declare(strict_types=1);

require_once __DIR__ . '/db_connect.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
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

	if (!password_verify($plainPassword, $user['password_hash'])) {
		return null;
	}

	$updateLogin = $pdo->prepare('UPDATE users SET last_login = NOW() WHERE user_id = :user_id');
	$updateLogin->execute(['user_id' => $user['user_id']]);

	unset($user['password_hash']);

	return $user;
}

function loginUser(array $user): void
{
	$_SESSION['user'] = $user['email'];
	$_SESSION['user_id'] = (int) $user['user_id'];
	$_SESSION['name'] = trim($user['first_name'] . ' ' . $user['last_name']);
	$_SESSION['role'] = strtolower((string) $user['role_code']);
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
