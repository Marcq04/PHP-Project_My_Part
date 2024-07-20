<?php
$servername = getenv('DB_SERVER');
$username = getenv('DB_USER');
$password = getenv('DB_PASS');
$dbname = getenv('DB_NAME');

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

$sql = "SELECT id, title, description, resources FROM paths";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<h2>Paths</h2>";
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Resources</th>
                <th>Actions</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['title']}</td>
        <td>{$row['description']}</td>
        <td>{$row['resources']}</td>
        <td>
            <a href='edit_path.php?id={$row['id']}'>Edit</a>
            <a href='delete_path.php?id={$row['id']}'>Delete</a>
        </td>
    </tr>";
    }
    echo "</table>";
}
else {
    echo "<p>No paths found.</p>";
}
$conn->close();
?>