<?php
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <form action="registration.php" method="POST">
            <?php
            class User
            {
                private $first_name;
                private $last_name;
                private $company_name;
                private $position;
                private $email;
                private $password;
                private $repeat_password;
                private $mobile_1;
                private $mobile_2;
                private $mobile_3;

                public function getFirstName()
                {
                    return $this->first_name;
                }

                public function setFirstName($first_name)
                {
                    $this->first_name = $first_name;
                }
                public function getLastName()
                {
                    return $this->last_name;
                }

                public function setLastName($last_name)
                {
                    $this->last_name = $last_name;
                }

                public function getCompanyName()
                {
                    return $this->company_name;
                }

                public function setCompanyName($company_name)
                {
                    $this->company_name = $company_name;
                }
                public function getPosition()
                {
                    return $this->position;
                }

                public function setPosition($position)
                {
                    $this->position = $position;
                }
                public function getEmail()
                {
                    return $this->email;
                }

                public function setEmail($email)
                {
                    $this->email = $email;
                }
                public function getPassword()
                {
                    return $this->password;
                }

                public function setPassword($password)
                {
                    $this->password = $password;
                }
                public function getRepeatPassword()
                {
                    return $this->repeat_password;
                }

                public function setRepeatPassword($repeat_password)
                {
                    $this->repeat_password = $repeat_password;
                }
                public function getMobile1()
                {
                    return $this->mobile_1;
                }

                public function setMobile1($mobile_1)
                {
                    $this->mobile_1 = $mobile_1;
                }
                public function getMobile2()
                {
                    return $this->mobile_2;
                }

                public function setMobile2($mobile_2)
                {
                    $this->mobile_2 = $mobile_2;
                }
                public function getMobile3()
                {
                    return $this->mobile_3;
                }

                public function setMobile3($mobile_3)
                {
                    $this->mobile_3 = $mobile_3;
                }
            }
            $new_user = new User();
            if (isset($_POST['submit'])) {
                $new_user->setFirstName($_POST["first_name"]);
                $new_user->setLastName($_POST["last_name"]);
                $new_user->setCompanyName($_POST["company_name"]);
                $new_user->setPosition($_POST["position"]);
                $new_user->setEmail($_POST["email"]);
                $new_user->setPassword($_POST["password"]);
                $new_user->setRepeatPassword($_POST["repeat_password"]);
                $new_user->setMobile1($_POST["mobile_1"]);
                $newUser->setMobile_2($_POST["mobile_2"]);
                $newUser->setMobile_3($_POST["mobile_3"]);
                $passwordHash = password_hash($new_user->getPassword(), PASSWORD_DEFAULT);
                $errors = array();
                if (empty($new_user->getFirstName()) or trim($new_user->getFirstName()) == '' or empty($new_user->getLastName()) or trim($new_user->getLastName()) == '' or empty($new_user->getEmail()) or empty($new_user->getPassword()) or trim($new_user->getEmail()) == '' or trim($new_user->getPassword()) == '') {
                    array_push($errors, "Не все обязательные поля заполнены!");
                }
                if (!filter_var($new_user->getEmail(), FILTER_VALIDATE_EMAIL)) {
                    array_push($errors, "Некорректный email!");
                }
                if (strlen($new_user->getPassword()) < 8) {
                    array_push($errors, "Пароль должен содержать не менее 8 символов!");
                }
                if ($new_user->getPassword() != $new_user->getRepeatPassword()) {
                    array_push($errors, "Пароли не совпадают!");
                }
                require_once "database.php";
                $sql = "SELECT * FROM users WHERE email = '$email'";
                $result = mysqli_query($conn, $sql);
                $rowCount = mysqli_num_rows($result);
                if ($rowCount > 0) {
                    array_push($errors, "Такой email уже зарегистрирован!");
                }
                if (count($errors) > 0) {
                    foreach ($errors as $error) {
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                } else {
                    //write to database
                    $sql = "INSERT INTO users (first_name, last_name, company_name, position, email, password, mobile_1, mobile_2, mobile_3) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = mysqli_stmt_init($conn);
                    $prepare = mysqli_stmt_prepare($stmt, $sql);
                    if ($prepare) {
                        mysqli_stmt_bind_param($stmt, "sssssssss", $first_name, $last_name, $company_name, $position, $email, $passwordHash, $mobile_1, $mobile_2, $mobile_3);
                        $execute = mysqli_stmt_execute($stmt);
                        if ($execute) {
                            echo "<div class='alert alert-success'> Регистрация прошла успешно </div>";
                        } else {
                            echo "<div class='alert alert-danger'> Не удалось выполнить запрос </div>";
                        }
                    } else {
                        die("Что-то пошло не так");
                    }
                }
            }
            ?>
            <style>
                input[name="first_name"]::placeholder,
                input[name="last_name"]::placeholder,
                input[name="email"]::placeholder,
                input[name="password"]::placeholder,
                input[name="repeat_password"]::placeholder {
                    color: red;
                }
            </style>
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