<?php 
session_start();
require "includes/pdo.php"; 
require "functions/user_functions.php"; 

$username = filter_input(INPUT_POST,'username');
$password = filter_input(INPUT_POST,'password');

if (isset($username) && isset($password)) {

    if ($username ==="" || $password ==="") {
        
        $errorMessage = 'All fields are required';
    }
    else {  

        if (authenticateUsers($username, $password, $pdo)) {

            $data = $pdo->query("SELECT * FROM user")->fetchAll();
            foreach ($data as $row) {
    
                if ($row['username'] === $username && $row['password'] === $password) {
    
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['username'] = $username;
                    $_SESSION['is_admin'] = $row['is_admin'];
                }

            }
            header("Location: ../home.php");
        }
        else {

            $errorMessage = "Not registered";
        }
    }
} 

require "partials/header.php"; 
?>

<nav>
    <div></div>
    <h1>Login Page</h1>
    <div></div>
</nav>

<div class="main">
    <div>
        <form class="login-form" method="post">
            <input class="form-field" type="text" name="username" placeholder="Username"><br>
            <input class="form-field" type="password" name="password" placeholder="Password"><br>
            <button class="submit-btn" type="submit" value="Envoyer"> Log in</button>

            <?php if (isset($errorMessage)) { ?>
        
                <p style="color:red; align-self: center;"><?= $errorMessage?></p>
        
            <?php } ?>
            <a href="./signin.php">Not registered ? Sign in here</a>
        </form>
    </div>
</div>

<?php
require "partials/footer.php"; 
?>