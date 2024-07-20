<?php
$servername = getenv('DB_SERVER');
$username = getenv('DB_USER');
$password = getenv('DB_PASS');
$dbname = getenv('DB_NAME');

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;port=3309", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection Failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $resources = $_POST['resources'];
    $errs = [];
    if(empty($title)) {
        $errs["title"] = "Please enter title";
    }
    if(empty($description)) {
        $errs["description"] = "Please enter description";
    }
    if(empty($resources)) {
        $errs["resources"] = "Please enter resources";
    }
    
    $sql = "UPDATE paths SET title = ?, description = ?, resources = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title, $description, $resources, $id]);

    header("Location: display_path.php?id=$id");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $pdo->prepare("SELECT id, title, description, resources FROM paths WHERE id = ?");
    $stmt->execute([$id]);
    $path = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$path) {
        die("Path not found.");
    }
} else {
    header("Location: display_path.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Path</title>
</head>
<body>
    <h2>Edit Path</h2>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="id" value="<?php echo $path['id']; ?>">

        <label for="title">Title:</label>
        <input type="text" name="title" value="<?php echo isset($path['title']) ? $path['title'] : ''; ?>" required><br>
        <span id="errorMessage" class="error-message"></span>
        <label for="description">Description: </label>
        <textarea name="description" required><?php echo isset($path['description']) ? $path['description'] : ''; ?></textarea><br>
        <span id="errorMessage" class="error-message"></span>
        <label for="resources">Resources: </label>
        <input type="text" name="resources" value="<?php echo isset($path['resources']) ? $path['resources'] : ''; ?>" required><br>
        <span id="errorMessage" class="error-message"></span>
        <input type="submit" value="Save Changes">
    </form>
</body>
</html>