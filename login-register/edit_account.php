<?php
// проверка на то, авторизован ли пользователь
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
require_once "User_class.php";
$new_user = new User();

require_once 'database.php';
$userId = $_SESSION['user_id'];
// получаем email от администратора, чтобы вывести человека из бд с этим email 
if (isset($_GET['email'])) {
    $email = $_GET['email'];

    $sql = "SELECT * FROM users WHERE email = '{$email}'";
    $result = mysqli_query($conn, $sql);
    $userData = mysqli_fetch_assoc($result);
} else {
    // это для обычного пользователя по его id 
    $sql = "SELECT * FROM users WHERE id = $userId";
    $result = mysqli_query($conn, $sql);
    $userData = mysqli_fetch_assoc($result);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_user->setFirstName($_POST["first_name"]);
    $new_user->setLastName($_POST["last_name"]);
    $new_user->setCompanyName($_POST["company_name"]);
    $new_user->setPosition($_POST["position"]);
    $new_user->setEmail($_POST["email"]);
    $new_user->setMobile1($_POST["mobile_1"]);
    $new_user->setMobile2($_POST["mobile_2"]);
    $new_user->setMobile3($_POST["mobile_3"]);
    $errors = array();
    // обычные проверки как и при регистрации
    if (trim($new_user->getFirstName()) == '' or  trim($new_user->getLastName()) == '' or  trim($new_user->getEmail()) == '') {
        array_push($errors, "Not all required fields are filled!");
    }
    if (!filter_var($new_user->getEmail(), FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Incorrect email!");
    }
    require_once "database.php";
    $sql = "SELECT * FROM users WHERE email = '{$new_user->getEmail()}'";
    $result = mysqli_query($conn, $sql);
    $rowCount = mysqli_num_rows($result);
    if ($rowCount > 0) {
        $userData = mysqli_fetch_assoc($result);
        // костыль, если это администратор, тогда он может ввести даже повторяющийся email
        if (!isset($_SESSION['admin'])) {
            if ($userData['id'] != $userId) {
                array_push($errors, "This email is already registered!");
            }
        }
    }
    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    } else {
        // проверка на то, является ли пользователь администратором и если да, тогда обновляяем данные
        if (isset($_SESSION['admin'])) {
            $sql = "UPDATE users SET 
            first_name = '{$new_user->getFirstName()}',
            last_name = '{$new_user->getLastName()}',
            company_name = '{$new_user->getCompanyName()}',
            position = '{$new_user->getPosition()}',
            email = '{$new_user->getEmail()}',
            mobile_1 = '{$new_user->getMobile1()}',
            mobile_2 = '{$new_user->getMobile2()}',
            mobile_3 = '{$new_user->getMobile3()}'
            WHERE email = '{$new_user->getEmail()}'";
            if (mysqli_query($conn, $sql)) {
                mysqli_close($conn);
                header('Location: index.php');
                exit;
            } else {

                echo "Error with updating account: " . mysqli_error($conn);
                mysqli_close($conn);
            }
        }
        // если пользователь не является администратором, тогда созрняем через id 
        $sql = "UPDATE users SET 
    first_name = '{$new_user->getFirstName()}',
    last_name = '{$new_user->getLastName()}',
    company_name = '{$new_user->getCompanyName()}',
    position = '{$new_user->getPosition()}',
    email = '{$new_user->getEmail()}',
    mobile_1 = '{$new_user->getMobile1()}',
    mobile_2 = '{$new_user->getMobile2()}',
    mobile_3 = '{$new_user->getMobile3()}'
    WHERE id = $userId";
        if (mysqli_query($conn, $sql)) {
            mysqli_close($conn);
            header('Location: index.php');
            exit;
        } else {

            echo "Error with updating account: " . mysqli_error($conn);
            mysqli_close($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- подключаем bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Account edit</title>
</head>

<body>
    <div class="container">
        <h2>Editing</h2>
        <form action="edit_account.php" method="POST">
            <!-- выводим поля, которые можно отредактировать  -->
            <div class="form-group">
                <label for="first_name">Name:</label>
                <input class="form-control" type="text" name="first_name" value="<?php echo $userData['first_name']; ?>"><br>
            </div>
            <div class="form-group">
                <label for="last_name">Surname:</label>
                <input class="form-control" type="text" name="last_name" value="<?php echo $userData['last_name']; ?>"><br>
            </div>
            <div class="form-group">
                <label for="company_name">Company name:</label>
                <input class="form-control" type="text" name="company_name" value="<?php echo $userData['company_name']; ?>"><br>
            </div>
            <div class="form-group">
                <label for="position">Position:</label>
                <input class="form-control" type="text" name="position" value="<?php echo $userData['position']; ?>"><br>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input class="form-control" type="email" name="email" value="<?php echo $userData['email']; ?>"><br>
            </div>
            <div class="form-group">
                <label for="mobile_1">Phone number:</label>
                <input class="form-control" type="text" name="mobile_1" value="<?php echo $userData['mobile_1']; ?>"><br>
            </div>
            <div class="form-group">
                <label for="mobile_2">Additional phone number:</label>
                <input class="form-control" type="text" name="mobile_2" value="<?php echo $userData['mobile_2']; ?>"><br>
            </div>
            <div class="form-group">
                <label for="mobile_3">Additional phone number:</label>
                <input class="form-control" type="text" name="mobile_3" value="<?php echo $userData['mobile_3']; ?>"><br>
            </div>
            <div class="btn btn-primary">
                <input type="submit" class="btn btn-primary" name="confirm" value="Сохранить изменения">
            </div>
        </form>
    </div>
</body>

</html>