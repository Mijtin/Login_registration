<?php
session_start();
// проверка на то, авторизован ли пользователь
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
}
// проверка на то, является ли авторизованный пользователь администратором
if (isset($_SESSION['admin'])){
    require_once 'database.php';
    if (isset($_GET['email'])) {
        $email = $_GET['email'];
        $sql = "DELETE FROM users WHERE email = '{$email}'";
        if (mysqli_query($conn, $sql)) {
            header('Location: index.php');
            echo "Account deleted.";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
        mysqli_close($conn);
    }
}
?>
<?php
// удаление для обычных пользователей
// если нажали кнопку с подтверждением удаления аккаунта
if (isset($_POST['confirm'])) {
    // подключаем базу данных
    require_once 'database.php';
    $userId = $_SESSION['user_id'];
    $sql = "DELETE FROM users WHERE id = $userId";
    // проверем существование пользователя
    if (mysqli_query($conn, $sql)) {
        header('Location: index.php');
        echo "Account deleted.";
        session_destroy();
        header("Location: login.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    mysqli_close($conn);
} ?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Deleting account</title>
    <!-- подключаем bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h2>Deleting account</h2>
        <p>Are you sure ? You want to delete your account.</p>
        <!-- кнопки для подтверждения удаления и отмены -->
        <form action="delete_account.php" method="POST">
            <div class="btn btn-danger">
                <input type="submit" name="confirm" value="Delete" class="btn btn-danger">
            </div>
            <div class="btn btn-primary">
                <a href="index.php" type="submit" name="confirm" class="btn btn-primary">Cancel</a>
            </div>
        </form>
    </div>
</body>

</html>