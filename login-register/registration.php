<?php
// проверка на то, авторизован ли пользователь
session_start();
if (isset($_SESSION['user'])) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration form</title>
    <!-- подключаем bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <form action="registration.php" method="POST">
            <?php
            // подключение к классу User, он хранит в себе данные о пользователе, в нём есть геттеры и сеттеры
            require_once "User_class.php";
            $new_user = new User();
            // выполняется если нажали кнопку с именем submit
            if (isset($_POST['submit'])) {
                $new_user->setFirstName($_POST["first_name"]);
                $new_user->setLastName($_POST["last_name"]);
                $new_user->setCompanyName($_POST["company_name"]);
                $new_user->setPosition($_POST["position"]);
                $new_user->setEmail($_POST["email"]);
                $new_user->setPassword($_POST["password"]);
                $new_user->setRepeatPassword($_POST["repeat_password"]);
                $new_user->setMobile1($_POST["mobile_1"]);
                $new_user->setMobile2($_POST["mobile_2"]);
                $new_user->setMobile3($_POST["mobile_3"]);
                $passwordHash = password_hash($new_user->getPassword(), PASSWORD_DEFAULT);
                $errors = array();
                // проверка на то, что поля не пустные и не заполнены пробелами
                if (empty($new_user->getFirstName()) or trim($new_user->getFirstName()) == '' or empty($new_user->getLastName()) or trim($new_user->getLastName()) == '' or empty($new_user->getEmail()) or empty($new_user->getPassword()) or trim($new_user->getEmail()) == '' or trim($new_user->getPassword()) == '') {
                    array_push($errors, "Not all required fields are filled!");
                }
                // проверка на то, что email правильный
                if (!filter_var($new_user->getEmail(), FILTER_VALIDATE_EMAIL)) {
                    array_push($errors, "Incorrect email!");
                }
                // проверка на то, что пароль длиннее 8 символов
                if (strlen($new_user->getPassword()) < 8) {
                    array_push($errors, "Password must contain at least 8 characters!");
                }
                // проверка на то, что пароли совпадают
                if ($new_user->getPassword() != $new_user->getRepeatPassword()) {
                    array_push($errors, "Passwords do not match!");
                }
                // подключение базы данных
                require_once "database.php";
                $sql = "SELECT * FROM users WHERE email = '{$new_user->getEmail()}'";
                $result = mysqli_query($conn, $sql);
                $rowCount = mysqli_num_rows($result);
                // проверка на то, что email уже занят
                if ($rowCount > 0) {
                    array_push($errors, "This email is already registered!");
                }
                // если есть ошибки
                if (count($errors) > 0) {
                    foreach ($errors as $error) {
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                } else {
                    //записывает в базу данных
                    $sql = "INSERT INTO users (first_name, last_name, company_name, position, email, password, mobile_1, mobile_2, mobile_3) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = mysqli_stmt_init($conn);
                    $prepare = mysqli_stmt_prepare($stmt, $sql);
                    if ($prepare) {
                        $first_name = $new_user->getFirstName();
                        $last_name = $new_user->getLastName();
                        $company_name = $new_user->getCompanyName();
                        $position = $new_user->getPosition();
                        $email = $new_user->getEmail();
                        $mobile_1 = $new_user->getMobile1();
                        $mobile_2 = $new_user->getMobile2();
                        $mobile_3 = $new_user->getMobile3();
                        mysqli_stmt_bind_param($stmt, "sssssssss", $first_name, $last_name, $company_name, $position, $email, $passwordHash, $mobile_1, $mobile_2, $mobile_3);
                        $execute = mysqli_stmt_execute($stmt);
                        if ($execute) {
                            echo "<div class='alert alert-success'> Registration successful </div>";
                        } else {
                            echo "<div class='alert alert-danger'> Something went wrong </div>";
                        }
                    } else {
                        die("Something went wrong");
                    }
                }
            }
            ?>
            <!-- перекрашиваем обязательные поля в крассный -->
            <style>
                input[name="first_name"]::placeholder,
                input[name="last_name"]::placeholder,
                input[name="email"]::placeholder,
                input[name="password"]::placeholder,
                input[name="repeat_password"]::placeholder {
                    color: red;
                }
            </style>
            <!-- выводим все поля для регистрации -->
            <div class="form-group">
                <input type="text" name="first_name" class="form-control" placeholder="First name*">
            </div>
            <div class="form-group">
                <input type="text" name="last_name" class="form-control" placeholder="Last name*">
            </div>
            <div class="form-group">
                <input type="text" name="company_name" class="form-control" placeholder="Company name">
            </div>
            <div class="form-group">
                <input type="text" name="position" class="form-control" placeholder="Position">
            </div>
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Email*">
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password*">
            </div>
            <div class="form-group">
                <input type="password" name="repeat_password" class="form-control" placeholder="Repeat password*">
            </div>
            <div class="form-group">
                <input type="text" name="mobile_1" class="form-control" placeholder="Phone number">
            </div>
            <div class="form-group">
                <input type="text" name="mobile_2" class="form-control" placeholder="Additional phone number">
            </div>
            <div class="form-group">
                <input type="text" name="mobile_3" class="form-control" placeholder="Additional phone number">
            </div>
            <div class="form-bnt">
                <input type="submit" name="submit" class="btn btn-primary" value="Registration">
            </div>
            <div>
                <p>Already registered? <a href="login.php">Enter</a></p>
            </div>
    </div>
</body>

</html>