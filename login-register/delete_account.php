<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
}
?>
<?php


if (isset($_POST['confirm'])) { 
    require_once 'database.php';
    $userId = $_SESSION['user_id'];
    $sql = "DELETE FROM users WHERE id = $userId";
    if (mysqli_query($conn, $sql)) {
        header('Location: index.php'); 
        echo "Аккаунт успешно удален.";
        session_destroy();
        header("Location: login.php");
    } else {
        echo "Ошибка при удалении аккаунта: " . mysqli_error($conn);
    }
    mysqli_close($conn);
} ?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Удаление аккаунта</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h2>Удаление аккаунта</h2>
        <p>Вы уверены, что хотите удалить аккаунт? Это действие нельзя отменить.</p>
        <form action="delete_account.php" method="POST">
            <div class="btn btn-danger">
                <input type="submit" name="confirm" value="Подтвердить удаление" class="btn btn-danger">
            </div>
            <div class="btn btn-primary">
                <a href="index.php" type="submit" name="confirm" class="btn btn-primary">Отмена</a>
            </div>
        </form>
    </div>
</body>

</html>