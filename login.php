<?php
// session_start();


// $servername = "localhost:3306";
// $db_username = "root";
// $db_password = "";
// $dbname = "recipe_site";

// $conn = new mysqli($servername, $db_username, $db_password, $dbname);


// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }


// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $username = $_POST['username'];
//     $password = $_POST['password'];

    
//     $sql = "SELECT * FROM users WHERE username = ?";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("s", $username);
//     $stmt->execute();
//     $result = $stmt->get_result();

//     if ($result->num_rows > 0) {
//         $user = $result->fetch_assoc();

       
//         if (password_verify($password, $user['password'])) {
//             // Password is correct, start a session and grant access
//             $_SESSION['user_id'] = $user['id'];
//             $_SESSION['username'] = $user['username'];
//             // Redirect to add recipe page
//             header("Location: add_recipe_html.php");
//             exit();
//         } else {
//             echo "Invalid password.";
//         }
//     } else {
//         echo "No user found with that username.";
//     }

//     // Close statement and connection
//     $stmt->close();
//     $conn->close();
// } else {
//     echo "Invalid request method.";
// }
session_start();
 $servername = "localhost:3306";
 $db_username = "root";
 $db_password = "";
 $dbname = "recipe_site";

 $conn = new mysqli($servername, $db_username, $db_password, $dbname);


 if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
 }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    
    $sql = "SELECT  username, password, user_type_name FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_type_name'] = $user['user_type_name']; 

         
            if ($_SESSION['user_type_name'] === 'Recipe Owner') {
                header("Location: recipe_owner_html.php");
            } else {
                header("Location: displayUsers.php");
            }
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that username.";
    }

    $stmt->close();
}

?>
