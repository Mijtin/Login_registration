
<?php
// проверка на то, авторизован ли пользователь
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
    <!-- подключаем bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <?php if (isset($_SESSION['admin'])): ?>
        <!-- кнопка для панели администратора -->
        <a href="admin_home.php" class="btn btn-success">Admin Panel</a>
        <?php endif; ?>
        <h1>Welcome</h1>
        <?php
        // Подключение к БД
        require_once "database.php";

        $recordsPerPage = 10;
        // Вычисление номера страницы
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
            echo '<table class="table">';
            echo '<tr>';
            echo '<th>Name</th>';
            echo '<th>Surname</th>';
            echo '<th>Email</th>';
            echo '<th>Company name</th>';
            echo '<th>Position</th>';
            echo '</tr>';
            // Вывод данных каждого аккаунта
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row["first_name"] . '</td>';
                echo '<td>' . $row["last_name"] . '</td>';
                echo '<td>' . $row["email"] . '</td>';
                echo '<td>' . $row["company_name"] . '</td>';
                echo '<td>' . $row["position"] . '</td>';
                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo "No records.";
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

        <!-- кнопки для других действий -->
        <a href="edit_account.php" class="btn btn-primary">Edit your account</a>
        <a href="logout.php" class="btn btn-warning" style="margin-left: 10px;">Log out</a>
        <a href="delete_account.php" class="btn btn-danger" style="margin-left: 140px;  ">Delete your account</a>

    </div>
</body>

</html>