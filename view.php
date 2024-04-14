<HTML>
<BODY>
    <title>Данные из таблицы</title>

<?php
$key1 = 0;
echo "<b> Работа с данными на сервере MySQL </b> "."<br>"."<br>";
$sdb_name = "localhost";
$user_name = "root";
$user_pass = "";
$db_name = "coffeehouse_db";

// Соединение с сервером MySQL
$link = mysql_connect($sdb_name, $user_name, $user_pass);
echo "Отчет о сервере MySQL"."<br>"."<br>";
if (!$link) { 
    echo "Не удалось подключиться к серверу MySQL"."<br>";
    exit();
} 
echo "Подключение к серверу MySQL - Успешно"."<br>";

// Выбор базы данных coffeehouse_db
if (!mysql_select_db($db_name, $link)) {
    echo "Не удалось выбрать базу данных"."<br>"; 
    exit();
}
echo "База данных открыта успешно"."<br>";

// Запрос к таблице menu
$str_sql_query_menu = "SELECT * FROM menu";
if (!$result_menu = mysql_query($str_sql_query_menu, $link)) {
    echo "Не удалось выполнить запрос к таблице menu"."<br>"; 
    exit();
}
echo "Запрос к таблице menu выполнен успешно"."<br>";

// Вывод данных из таблицы menu
echo "<H2 ALIGN=CENTER> <b> Вывод из таблицы menu базы данных restaurant_db </b> </H2>";
echo "<table cols=5 border=1 WIDTH=600 CELLPADDING=5 ALIGN=CENTER>\n";
echo "<tr> <td> ID </td> <td> Название напитка </td> <td> Описание </td> <td> Цена </td> </tr>";

// Формирование HTML-таблицы с данными из таблицы menu
while ($row_menu = mysql_fetch_assoc($result_menu)) {
    echo "<tr>";
    echo "<td>".$row_menu['id']."</td>";
    echo "<td>".$row_menu['name']."</td>";
    echo "<td>".$row_menu['composition']."</td>";
    echo "<td>".$row_menu['price']."</td>";
    echo "</tr>";
}
echo "</table>";

// Закрытие соединения с сервером MySQL
mysql_close($link);
?>
</BODY>
</HTML>
