<?php
 $servername = "localhost:3306";
 $username_db = "root";
 $password_db = "";
 $dbname = "recipe_site";

 if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_name = $_POST["category_name"];
    $conn = new mysqli($servername, $username_db, $password_db, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO categories (category_name) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $category_name);

    if ($stmt->execute()) {
        echo "Category added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
