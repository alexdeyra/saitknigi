<?php
$servername = "localhost"; 
$username = "root";        
$password = "";            
$dbname = "Authorization"; // Исправлено на Authorization

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search = $conn->real_escape_string($_POST['search']);

    $sql = "SELECT * FROM Книги WHERE Наименование LIKE '%$search%' OR Автор LIKE '%$search%' OR Жанр LIKE '%$search%' OR Год_издания LIKE '%$search%' OR Издательство LIKE '%$search%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Результаты поиска:</h2>";
        echo "<table border='1'>
                <tr>
                    <th>Номер</th>
                    <th>Наименование</th>
                    <th>Автор</th>
                    <th>Жанр</th>
                    <th>Год издания</th>
                    <th>Издательство</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["Номер"] . "</td>
                    <td>" . $row["Наименование"] . "</td>
                    <td>" . $row["Автор"] . "</td>
                    <td>" . $row["Жанр"] . "</td>
                    <td>" . $row["Год_издания"] . "</td>
                    <td>" . $row["Издательство"] . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Книги не найдены.</p>";
    }
}

$conn->close();
?>