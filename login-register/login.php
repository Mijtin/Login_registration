<?php
session_start();
if (isset($_SESSION['user'])) {
    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <?php
        require_once 'registration.php';
        $new_user = new User();
        if (isset($_POST["login"])) {
            $new_user->setEmail($_POST["email"]);
            $new_user->setPassword($_POST["password"]);
            require_once 'database.php';
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if ($user) {
                if (password_verify($new_user->getPassword(), $user["password"])) {
                    session_start();
                    $_SESSION["user"] = "yes";
                    $_SESSION["user_id"] = $user["id"];
                    header("Location: index.php");
                    die();
                } else {
                    echo "<div class='alert alert-danger'>Пароль неверный</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Email неверный</div>";
            }
        }
        ?>
        <form action="login.php" method="POST">
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Enter your email">
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Enter your пароль">
            </div>
            <div class="form-btn">
                <input type="submit" name="login" class="btn btn-primary" value="Enter" style="color: white;">
            </div>
        </form>
        <div>
            <p> Not registered ? <a href="registration.php">Sign up</a></p>
        </div>
    </div>
</body>

</html>