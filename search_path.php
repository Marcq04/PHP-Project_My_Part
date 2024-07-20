<?php
$servername = getenv('DB_SERVER');
$username = getenv('DB_USER');
$password = getenv('DB_PASS');
$dbname = getenv('DB_NAME');

try {
    $pdo = new PDO("mysql:host=$servername; dbname=f3448926_project1;port=3309", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchField = $_POST['search_field'];
    $searchQuery = $_POST['search_query'];

    $errs = [];
    if(empty($searchField)) {
        $errs["searchField"] = "Please enter in the search field";
    }
    if(empty($searchQuery)) {
        $errs["description"] = "Please enter in the search query";
    }
    $sql = "SELECT id, title, description, resources FROM paths WHERE $searchField LIKE ?";
    $stmt = $pdo-> prepare($sql);
    $stmt->execute(["%$searchQuery%"]);
    $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Paths</title>
</head>
<body>
    <h2>Search Paths</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="search_field">Search by:</label>
        <span id="errorMessage" class="error-message"></span>
        <select name="search_field" required>
            <option value="id">ID</option>
            <option value="title">Title</option>
            <option value="description">Description</option>
            <option value="resources">Resources</option>
        </select>

        <label for="search_query">Search Query:</label>
        <input type="text" name="search_query" required>
        <span id="errorMessage" class="error-message"></span>
        <input type="submit" value="Search">
    </form>
<?php
if (isset($searchResults)) {
    if (count($searchResults) > 0) {
        echo "<h3>Search Results</h3>";
        echo "<table border = '1'> 
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Resources</th>
                </tr>";
        foreach ($searchResults as $result) {
            echo "<tr>
            <td>{$result['id']}</td>
            <td>{$result['title']}</td>
            <td>{$result['description']}</td>
            <td>{$result['resources']}</td>
        </tr>";
        }
        echo "</table>";
    }
    else {
        echo "<p>No results found.</p>";
    }
}
?>
</body>
</html>