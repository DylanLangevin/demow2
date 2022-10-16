<?php

function createPost(string $content, int $user_id, $pdo)
{
    $query = 'INSERT INTO post (content, user_id) VALUES (:content, :user_id)';

    $statement = $pdo->prepare($query);

    $statement->execute([

        ':content' => $content,
        ':user_id' => $user_id
    ]);
}

function deletePost(int $id, $pdo)
{
    $query = "DELETE FROM `post` WHERE id=?";

    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);
}

?>