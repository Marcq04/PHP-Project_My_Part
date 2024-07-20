<?php
$servername = getenv('DB_SERVER');
$username = getenv('DB_USER');
$password = getenv('DB_PASS');
$dbname = getenv('DB_NAME');

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;port=3309", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $pdo->prepare("DELETE FROM paths WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: display_path.php");
    exit();
}
else {
    die("Invalid Request.");
}
?>