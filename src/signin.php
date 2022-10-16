<?php 
session_start();
require "functions/user_functions.php"; 
require "includes/pdo.php"; 

$username = filter_input(INPUT_POST,'username');
$password = filter_input(INPUT_POST,'password');
$isAdmin = filter_input(INPUT_POST,'is_admin');

if ($isAdmin === "on") {

    $isAdmin = 1;
} 
else {

    $isAdmin = 0;
}

if (isset($username) && isset($password)) {
    
    if ($username ==="" || $password ==="") {
        
        $errorMessage = 'All fields are required';
    }
    else {

        if (authenticateUsers($username, $password, $pdo)) {

            $errorMessage = "Already have an account, log in !";
        }
        else {

            createUser($username, $password, $isAdmin, $pdo);
            $data = $pdo->query("SELECT * FROM user")->fetchAll();
            foreach ($data as $row) {
    
                if ($row['username'] === $username && $row['password'] === $password) {
    
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['username'] = $username;
                    $_SESSION['is_admin'] = $row['is_admin'];
                }
            }
            header("Location: ./home.php");
        }
        
    }
}

require "partials/header.php"; ?>
<nav>
    <div></div>
    <h1>Signin Page</h1>
    <div></div>
</nav>
<div class="main">
    <div>
        <form class="login-form" method="post">
            <input class="form-field" type="text" name="username" placeholder="Username"><br>
            <input class="form-field" type="password" name="password" placeholder="Password"><br>
            <div class="flex-row">
                <div style="margin-right:100px">
                    <label style="color:#094095" for="password">Admin?</label>
                    <input type="checkbox" name="is_admin"><br>
                </div>
                <button class="submit-btn" type="submit" value="Envoyer"> Sign in</button>
            </div>
            
            <?php if (isset($errorMessage)) { ?>
        
                <p style="color:red; align-self: center;"><?= $errorMessage?></p>
        
            <?php } ?>
            <a href="./index.php">Already have an account ? Log in here</a>
        </form>
    </div>
</div>
<?php require "partials/footer.php"; ?>