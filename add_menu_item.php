<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавление позиции в меню</title>
</head>
<body>

    <h2>Добавить позицию в меню:</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="name">Название:</label><br>
        <input type="text" id="name" name="name"><br>
        <label for="composition">Описание:</label><br>
        <textarea id="composition" name="composition"></textarea><br>
        <label for="price">Цена:</label><br>
        <input type="text" id="price" name="price"><br><br>
        <button type="submit">Добавить позицию</button>
    </form>

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

    // Обработка запроса на добавление данных
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];
        $composition = $_POST["composition"];
        $price = $_POST["price"];

        $sql = "INSERT INTO menu (name, composition, price) VALUES ('$name', '$composition', '$price')";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Новая запись успешно добавлена в меню!</p>";
        } else {
            echo "<p>Ошибка при добавлении записи: " . $conn->error . "</p>";
        }
    }

    // Вывод таблицы с данными
    $sql = "SELECT * FROM menu";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Текущее меню:</h2>";
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Состав</th>
                    <th>Цена</th>
                </tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>".$row["id"]."</td>
                    <td>".$row["name"]."</td>
                    <td>".$row["composition"]."</td>
                    <td>".$row["price"]."</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>0 результатов</p>";
    }

    $conn->close();
    ?>
</body>
</html>

