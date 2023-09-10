<?php
// проверка на то является ли авторизованный пользователь админом или нет
session_start();
if (!isset($_SESSION['user']) ||  !$_SESSION['admin']) {
    header('Location: login.php');
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Admin Dashboard</title>
</head>

<body>
    <div class="container">
        <h2>Admin</h2>
        <!-- кнопки для администратора -->
        <form action="edit_account.php" method="GET">
            <div class="form-group"> <input type="email" name="email" class="form-control" placeholder="Email"> </div> 
        <button type="submit" class="btn btn-primary">Edit Account</button>
        </form>
        <form action="delete_account.php" method="GET" style="margin-top: 20px;">
            <div class="form-group"> <input type="email" name="email" class="form-control" placeholder="Email" > </div> 
            <button type="submit" class="btn btn-secondary" style="margin-bottom: 20px;">Delete account</button>
        </form>
        <a href="index.php" type="submit" name="confirm" class="btn btn-primary">Cancel</a>
    </div>
</body>

</html>