<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The PATHS</title>
</head>
<body>
    <h2>Add a New Path</h2>  
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = $_POST["title"];
        $description = $_POST["description"];
        $resources = $_POST["resources"];

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
        else {
            $servername = 'localhost';
            $username = 'root';
            $password = '';
            $dbname = 'f3448926_project1';
            try {
                $pdo = new PDO("mysql:host=$servername;dbname=$dbname;port=3309", $username, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "INSERT INTO paths (title, description, resources, created_at) VALUES (?, ?, ?, NOW())";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(1, $title);
                $stmt->bindParam(2, $description);
                $stmt->bindParam(3, $resources);
                $stmt->execute();

                echo "Path added successfully.";
        }    catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label>Title: </label>
        <input type="text" name="title" required><br>
        <span id="errorMessage" class="error-message"></span>
        <label>Description: </label>
        <textarea name="description" required></textarea><br>
        <span id="errorMessage" class="error-message"></span>
        <label>Resources: </label>
        <input type="text" name="resources" required><br>
        <span id="errorMessage" class="error-message"></span>
        <input type="submit" value="Add Path"><br>
    </form>
</body>
</html>