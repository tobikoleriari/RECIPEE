<?php
 $servername = "localhost:3306";
 $username_db = "root";
 $password_db = "";
 $dbname = "recipe_site";

 $conn = new mysqli($servername, $username_db, $password_db, $dbname);

 if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
 }
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recipe_name = $_POST['recipe_name'];
    $ingredients = $_POST['ingredients'];
    $recipe_owner = $_POST['recipe_owner'];
    $category_name = $_POST['category_name'];
    $recipe_image = "";
    // $steps = $_POST['steps'];
    $steps = isset($_POST['steps']) ? $_POST['steps'] : ''; 


if (isset($_FILES['recipe_image']) && $_FILES['recipe_image']['error'] == UPLOAD_ERR_OK) {
    $recipe_image = 'uploads/' . basename($_FILES['recipe_image']['name']);
    move_uploaded_file($_FILES['recipe_image']['tmp_name'], $recipe_image);
}
$target_dir = "uploads/";
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);  // Create directory if it does not exist
}

$target_file = $target_dir . basename($_FILES["recipe_image"]["name"]);
if (move_uploaded_file($_FILES["recipe_image"]["tmp_name"], $target_file)) {
    echo "The file " . htmlspecialchars(basename($_FILES["recipe_image"]["name"])) . " has been uploaded.";
} else {
    // echo "Sorry, there was an error uploading your file.";
}

  
   

    $sql = "INSERT INTO recipes (recipe_name, ingredients, recipe_image, recipe_owner, category_name ,steps ) VALUES (?, ?, ?, ?, ?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $recipe_name, $ingredients, $recipe_image, $recipe_owner, $category_name, $steps);

    if ($stmt->execute()) {
        echo "Recipe added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
