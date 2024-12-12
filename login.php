<?php 
$servername = "127.0.0.1"; 
$username = "root"; 
$password = ""; 
$dbname = "Authorization"; // Исправлено на Authorization

$conn = new mysqli($servername, $username, $password, $dbname); 

if ($conn->connect_error) { 
    die("Ошибка подключения: " . $conn->connect_error); 
} 

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $login = $_POST['login']; 
    $password = $_POST['password']; 

    $stmt = $conn->prepare("SELECT `Пароль` FROM `Authorization` WHERE `Логин` = ?");
    $stmt->bind_param("s", $login); 

    $stmt->execute();
    $result = $stmt->get_result(); 

    if ($result->num_rows > 0) { 
        $row = $result->fetch_assoc(); 
        if (password_verify($password, $row['Пароль'])) { 
            header("Location: datawatch.html"); 
            exit(); 
        } else { 
            echo "<script>alert('Неправильный пароль'); window.location.href = 'login.html';</script>"; 
        } 
    } else { 
        echo "<script>alert('Такого логина нет, зарегистрируйтесь'); window.location.href = 'login.html';</script>"; 
    } 

    $stmt->close();
} 

$conn->close();
?>