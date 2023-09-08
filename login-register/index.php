<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">

        <h1>Welcome</h1>
        <?php
        require_once "database.php";
        $recordsPerPage = 10;
        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $currentPage = $_GET['page'];
        } else {
            $currentPage = 1;
        }
        // Вычисление смещения для LIMIT в SQL-запросе
        $offset = ($currentPage - 1) * $recordsPerPage;

        $sql = "SELECT * FROM users LIMIT $offset, $recordsPerPage";
        $result = mysqli_query($conn, $sql);
        // Проверка наличия результатов
        if ($result->num_rows > 0) {
            // Вывод данных каждого аккаунта
            while ($row = $result->fetch_assoc()) {
                echo '<div class="form2-group">';
                echo "Name: " . $row["first_name"] . "<br>";

                echo "Surname: " . $row["last_name"] . "<br>";

                echo "Email: " . $row["email"] . "<br>";
                echo "----------------------------------";
                echo '</div>';
            }   
        } else {
            echo "Нет данных аккаунтов.";
        }
        // Запрос для получения общего количества записей
        $sqlCount = "SELECT COUNT(*) AS total FROM users";
        $resultCount = mysqli_query($conn, $sqlCount);
        $rowCount = mysqli_fetch_assoc($resultCount)['total'];
        // Вычисление общего количества страниц
        $totalPages = ceil($rowCount / $recordsPerPage);

        // Отображение постраничной навигации
        echo "<nav>";
        echo "<ul class='pagination'>";
        for ($i = 1; $i <= $totalPages; $i++) {
            echo "<li class='page-item'><a class='page-link' href='index.php?page=$i'>$i</a></li>";
        }
        echo "</ul>";
        echo "</nav>";

        $conn->close();
        ?>
        <a href="edit_account.php" class="btn btn-primary">Edit your account</a>
        <a href="logout.php" class="btn btn-warning" style="margin-left: 10px;">Log out</a>
        <a href="delete_account.php" class="btn btn-danger" style="margin-left: 192px;  ">Delete your account</a>  

    </div>
</body>

</html>