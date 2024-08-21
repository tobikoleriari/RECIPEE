<?php
session_start();
$servername ="localhost:3306";
$username ="root";
$password="";
$dbname="recipe_site";

$conn = mysqli_connect($servername,$username, $password, $dbname);
if(!$conn){
    die("fail".$conn->connect_error);
}else{
    echo "Connected";
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "form submitted";
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $ConfirmPassword =  $_POST['confirm_password'];
    $user_image = $_FILES['user_image'];
    $user_type_name = $_POST['user_type_name'];
    if ($password !== $ConfirmPassword) {
        echo "Passwords do not match";
        exit;
    }
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    if (isset($_FILES['user_image']) && $_FILES['user_image']['error'] == UPLOAD_ERR_OK) {
        $user_image = 'user_pics/' . basename($_FILES['user_image']['name']);
        move_uploaded_file($_FILES['user_image']['tmp_name'], $user_image);
    }
    $target_dir = "user_pics/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);  
    }
    
    $target_file = $target_dir . basename($_FILES["user_image"]["name"]);
    if (move_uploaded_file($_FILES["user_image"]["tmp_name"], $target_file)) {
        echo "The file " . htmlspecialchars(basename($_FILES["user_image"]["name"])) . " has been uploaded.";
    } else {
        // echo "Sorry, there was an error uploading your file.";
    }
    
  
    
    $sql = "INSERT INTO users (username, password, email, user_image, user_type_name) VALUES (?, ?, ?, ?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $username,  $hashedPassword, $email, $user_image, $user_type_name);

    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $stmt->close();
    $conn->close();
    
}else{
    echo " failed";
}
?>