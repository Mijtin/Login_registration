<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
require_once 'registration.php';
$new_user = new User();

require_once 'database.php';
$userId = $_SESSION['user_id'];

$sql = "SELECT * FROM users WHERE id = $userId";
$result = mysqli_query($conn, $sql);
$userData = mysqli_fetch_assoc($result);



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_user->setFirstName($_POST["first_name"]);
    $new_user->setLastName($_POST["last_name"]);
    $new_user->setCompanyName($_POST["company_name"]);
    $new_user->setPosition($_POST["position"]);
    $new_user->setEmail($_POST["email"]);
    $new_user->setMobile1($_POST["mobile_1"]);
    $newUser->setMobile_2($_POST["mobile_2"]);
    $newUser->setMobile_3($_POST["mobile_3"]);

    $sql = "UPDATE users SET 
    first_name = '$firstName',
    last_name = '$lastName',
    company_name = '$companyName',
    position = '$position',
    email = '$email',
    mobile_1 = '$mobile1',
    mobile_2 = '$mobile2',
    mobile_3 = '$mobile3'
    WHERE id = $userId";
    if (mysqli_query($conn, $sql)) {
        mysqli_close($conn);
        header('Location: index.php');
        exit;
    } else {

        echo "Ошибка при сохранении изменений: " . mysqli_error($conn);
        mysqli_close($conn);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Редактирование аккаунта</title>
</head>

<body>
    <div class="container">
        <h2>Редактирование</h2>
        <form action="edit_account.php" method="POST">
            <div class="form-group">
                <label for="first_name">Имя:</label>
                <input class="form-control" type="text" name="first_name" value="<?php echo $userData['first_name']; ?>"><br>
            </div>
            <div class="form-group">
                <label for="last_name">Фамилия:</label>
                <input class="form-control" type="text" name="last_name" value="<?php echo $userData['last_name']; ?>"><br>
            </div>
            <div class="form-group">
                <label for="company_name">Название компании:</label>
                <input class="form-control" type="text" name="company_name" value="<?php echo $userData['company_name']; ?>"><br>
            </div>
            <div class="form-group">
                <label for="position">Должность:</label>
                <input class="form-control" type="text" name="position" value="<?php echo $userData['position']; ?>"><br>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input class="form-control" type="email" name="email" value="<?php echo $userData['email']; ?>"><br>
            </div>
            <div class="form-group">
                <label for="mobile_1">Номер телефона:</label>
                <input class="form-control" type="text" name="mobile_1" value="<?php echo $userData['mobile_1']; ?>"><br>
            </div>
            <div class="form-group">
                <label for="mobile_2">Дополнительный телефон:</label>
                <input class="form-control" type="text" name="mobile_2" value="<?php echo $userData['mobile_2']; ?>"><br>
            </div>
            <div class="form-group">
                <label for="mobile_3">Дополнительный телефон:</label>
                <input class="form-control" type="text" name="mobile_3" value="<?php echo $userData['mobile_3']; ?>"><br>
            </div>
            <div class="btn btn-primary">
                <input type="submit" class="btn btn-primary" name="confirm" value="Сохранить изменения">
            </div>
        </form>
    </div>
</body>

</html>