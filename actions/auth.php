<?php
require_once __DIR__ . '/pdo.php';

function login($username, $password) {
    global $pdo;

    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user === false || !password_verify($password, $user['password'])) {
        return [
            'status' => false,
            'error' => 'Invalid username or password',
        ];
    }

    unset($user['password']);
    return [
        'status' => true,
        'id' => $user['id'],
        'username' => $user['username'],
    ];
}

function register($username, $password) {
    global $pdo;

    $stmt = $pdo->prepare('SELECT 1 FROM users WHERE username = :username');
    $stmt->execute(['username' => $username]);
    if ($stmt->fetchColumn() !== false) {
        return [
            'status' => false,
            'error' => 'Username already exists',
        ];
    }

    try {
        $pdo->beginTransaction();
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare(
            'INSERT INTO users (username, password) VALUES (:username, :password)'
        );
    
        $stmt->execute([
            'username' => $username,
            'password' => $passwordHash,
        ]);

        $pdo->commit();
        return [
            'status' => true,    
            'id' => $pdo->lastInsertId(),
            'username' => $username,
        ];

    } catch (PDOException $e) {
        // Handle the exception (e.g., log it)
        if($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        return [
            'status' => false,
            'error' => $e->getMessage(),
        ];
    }
}

function logout() {
    session_start();
    $_SESSION = [];
    session_unset();
    session_destroy();
}