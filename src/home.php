<?php 
session_start();

require "functions/post_functions.php"; 
require "includes/pdo.php"; 

$content = filter_input(INPUT_POST,'content');
$idToDelete = filter_input(INPUT_POST,'idToDelete');

if ($_SESSION['is_admin'] === 1) {

    $admin = 'Yup';
}
else {

    $admin = 'Nope :(';
} 

if(empty($_SESSION)) {

    header("Location: ./index.php");
}

if (isset($content)) {
    if($content !=="")
    {
        createPost($content,$_SESSION['user_id'], $pdo);
        header("Location: ./home.php");
    }
}

if (isset($idToDelete)) {

    deletePost($idToDelete, $pdo);
    unset($idToDelete);
}

$posts = $pdo->query("SELECT post.content, post.id, post.user_id, user.username, user.is_admin FROM post INNER JOIN user WHERE post.user_id = user.id ORDER BY post.created_at DESC")->fetchAll();

require "partials/header.php"; ?>

<div class="main">

    <nav>
        <p>Admin : <?= $admin ?></p>
        <h1>Profile : <?=$_SESSION['username']?></h1>
        <a href="./index.php">Logout</a>
    </nav>

    <div class="sidebar" >
        <p style="color:blue">You</p>
        <p style="color:orange">Admins</p>
        <p style="color:red">Other users</p>
    </div>

    <div class="form-section">
        <div class="post-form">
            <form class="post-form-creation" method="POST">
                <textarea class="post-form-field" type="text" name="content" placeholder="Something to say ?"></textarea>
                <button class="post-creation-btn" type="submit">Publish</button>
            </form>
        </div>
    </div>

    <div class="post-section">

        <?php foreach ($posts as $post) { ?>
        <div class="post">
            <div>

                <?php if ($post['is_admin'] === 1) { ?>

                    <strong style="color:orange"> 
                
                <?php } elseif ($_SESSION['username'] === $post["username"])  {?>

                    <strong style="color:blue"> 

                <?php } else { ?>

                    <strong style="color:red">

                <?php } ?>

                <?= $post["username"]?>  </strong><br>

                <p> <?= $post['content']?>  </p>
            </div>
        
            <?php if ($post['user_id'] === $_SESSION['user_id'] || $_SESSION['is_admin']) { ?>
        
            <form method="post">
                <button class="delete-btn" value="<?= $post['id'] ?>" name="idToDelete">X</button>
            </form>
        
            <?php } ?>
        </div>
        <?php } ?>

    </div>
</div>

<?php
require "partials/footer.php"; 
?>