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

$id = $_GET["id"];

// Обработка запроса на обновление данных
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $composition = $_POST["composition"];
    $price = $_POST["price"];
    
    $sql = "UPDATE menu SET name='$name', composition='$composition', price='$price' WHERE id='$id'";
    
    if ($conn->query($sql) === TRUE) {
        echo "Данные успешно обновлены!";
    } else {
        echo "Ошибка при обновлении данных: " . $conn->error;
    }
}

// Получение данных о позиции из меню
$sql = "SELECT * FROM menu WHERE id='$id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Позиция не найдена";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактирование позиции</title>
</head>
<body>
    <h1>Редактирование позиции в меню</h1>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $id); ?>">
        <label for="name">Название:</label><br>
        <input type="text" id="name" name="name" value="<?php echo $row["name"]; ?>"><br>
        <label for="composition">Состав:</label><br>
        <textarea id="composition" name="composition"><?php echo $row["composition"]; ?></textarea><br>
        <label for="price">Цена:</label><br>
        <input type="text" id="price" name="price" value="<?php echo $row["price"]; ?>"><br><br>
        <button type="submit">Сохранить изменения</button>
    </form>
</body>
</html>
