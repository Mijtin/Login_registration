<?php
// проверка на то, авторизован ли пользователь
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
         <!-- подключаем bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <?php
        // подключение к классу User, он хранит в себе данные о пользователе, в нём есть геттеры и сеттеры
        require_once "User_class.php";
        $new_user = new User();
        // если нажали кнопку с именем login
        if (isset($_POST["login"])) {
            $new_user->setEmail($_POST["email"]);
            $new_user->setPassword($_POST["password"]);
            require_once 'database.php';
            $sql = "SELECT * FROM users WHERE email = '{$new_user->getEmail()}'";
            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            // проверяем email пользователя
            if ($user) {
                // проверяем пароль
                if (password_verify($new_user->getPassword(), $user["password"])) {
                    session_start();
                    // записываем данные пользователя в сессию
                    $_SESSION["user"] = "yes";
                    $_SESSION["user_id"] = $user["id"];
                    // проверяем по почте является ли человек админом
                    if ($new_user->getEmail() === 'email1@mail.ru') {
                        $_SESSION['admin'] = true;
                    }
                    header("Location: index.php");
                    die();
                } else {
                    echo "<div class='alert alert-danger'>Password is incorrect<й</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Email is incorrect</div>";
            }
        }
        ?>
        <!-- поля для заполнения -->
        <form action="login.php" method="POST">
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Enter your email">
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Enter your password">
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