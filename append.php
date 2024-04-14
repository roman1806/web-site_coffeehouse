<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавление записей в таблицу (фоновый режим)</title>
</head>
<body>
    <h1>Кафедра Бизнес-информатика</h1>
    <h2>Научно-исследовательская работа</h2>

    <?php
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "coffeehouse_db";

    // Соединение с сервером MySQL
    $link = mysqli_connect($host, $username, $password, $dbname);

    // Проверка соединения
    if (!$link) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Подготовка SQL-запроса
    $sql = "INSERT INTO menu (name, composition, price) VALUES (?, ?, ?)";

    // Подготовка запроса
    if ($stmt = mysqli_prepare($link, $sql)) {
        // Привязываем параметры к подготовленному выражению
        mysqli_stmt_bind_param($stmt, "sss", $newname, $newcomposition, $newprice);

        // Установка параметров
        $newname = 'Латте';
        $newcomposition = 'Погрузитесь в мягкое облако нежности с нашим латте! Наслаждайтесь гармонией молочного вкуса, объединенного с ароматом свежесваренного кофе, чтобы создать идеальный баланс удовольствия и бодрости.';
        $newprice = '450';

        // Выполнение подготовленного запроса
        if (mysqli_stmt_execute($stmt)) {
            echo "Запись успешно добавлена!";
        } else {
            echo "Ошибка при выполнении запроса: " . mysqli_error($link);
        }

        // Закрытие запроса
        mysqli_stmt_close($stmt);
    } else {
        echo "Ошибка при подготовке запроса: " . mysqli_error($link);
    }

    // Закрытие соединения с сервером MySQL
    mysqli_close($link);
    ?>
</body>
</html>


