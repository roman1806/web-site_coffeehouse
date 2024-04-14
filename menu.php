<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "coffeehouse_db";

// Установка соединения с базой данных
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Обработка запроса на удаление позиции
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
    $id = $_POST["delete"];
    $sql = "DELETE FROM menu WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Позиция успешно удалена!";
    } else {
        echo "Ошибка при удалении позиции: " . $conn->error;
    }
}

// Обработка запроса на удаление дублирующихся позиций
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_duplicates"])) {
    $sql = "DELETE t1 FROM menu t1 JOIN menu t2 WHERE t1.id < t2.id AND t1.name = t2.name";
    if ($conn->query($sql) === TRUE) {
        echo "Дублирующиеся позиции успешно удалены!";
    } else {
        echo "Ошибка при удалении дублирующихся позиций: " . $conn->error;
    }
}

// Получение данных из таблицы menu
$sql = "SELECT * FROM menu";

// Обработка запроса на сортировку данных
if (isset($_GET["sort"])) {
    $sort = $_GET["sort"];
    $sql .= " ORDER BY $sort";
}

$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Меню кофейни</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <h1>Меню кофейни</h1>

    <table>
        <tr>
            <th><a href="?sort=id">ID</a></th>
            <th><a href="?sort=name">Название</a></th>
            <th><a href="?sort=composition">Состав</a></th>
            <th><a href="?sort=price">Цена</a></th>
            <th>Действия</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>".$row["id"]."</td>
                        <td>".$row["name"]."</td>
                        <td>".$row["composition"]."</td>
                        <td>".$row["price"]."</td>
                        <td>
                            <form method='post' action='".$_SERVER["PHP_SELF"]."'>
                                <input type='hidden' name='delete' value='".$row["id"]."'>
                                <button type='submit'>Удалить</button>
                            </form>
                            <form method='get' action='edit.php'>
                                <input type='hidden' name='id' value='".$row["id"]."'>
                                <button type='submit'>Редактировать</button>
                            </form>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>0 результатов</td></tr>";
        }
        ?>
    </table>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <button type="submit" name="delete_duplicates">Удалить дублирующие записи</button>
    </form>
</body>
</html>

