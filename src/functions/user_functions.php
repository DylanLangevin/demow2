<?php

function createUser(string $username, string $password, int $isAdmin, $pdo)
{
    $query = 'INSERT INTO user (username, password, is_admin) VALUES (:username, :password, :is_admin)';

    $statement = $pdo->prepare($query);

    $statement->execute([

        ':username' => $username,
        ':password' => $password,
        ':is_admin' => $isAdmin
    ]);
}

function authenticateUsers(string $username, string $password, $pdo)
{
    $data = $pdo->query("SELECT * FROM user")->fetchAll();

    foreach ($data as $row) {
        if ($row['username'] === $username && $row['password'] === $password) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $username;
            return true;
        }
    }
    return false;
}   
?>