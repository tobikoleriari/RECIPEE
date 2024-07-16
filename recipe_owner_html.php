<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ensure the user is logged in and is a recipe owner
if (!isset($_SESSION['username']) || $_SESSION['user_type_name'] != 'Recipe Owner') {
    header("Location: displayUsers.php");
    exit;
}

// Database connection
$serverName = "localhost:3306";
$userName = "root";
$password = "";
$dbName = "recipe_site";

$conn = new mysqli($serverName, $userName, $password, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user details
$username = $_SESSION['username'];
$query = "SELECT * FROM users WHERE username=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Recipe Owner Profile</title>
    <link rel="stylesheet" href="style.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap');

        body {
            /* background-image: url('loginpic.jpg'); */
            /* background-size: cover; */
            /* background-attachment: fixed; */
            font-family: 'Roboto', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            overflow: auto;
        }

        header {
            width: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 10px 20px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .user-info {
            font-weight: 500;
        }

        h1, p {
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .profile-container {
            text-align: center;
            margin-top: 50px;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
        }

        .profile-container img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            border: 4px solid #75474a;
            margin-bottom: 20px;
            margin-left: -80px;
        }

        .profile-container h1 {
            font-size: 2em;
            color: #75474a;
            margin-bottom: 10px;
        }

        .profile-container p {
            font-size: 1.2em;
            color: #555;
            margin-bottom: 20px;
        }

        .add-recipe-button {
            background-color: #75474a;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 1em;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .add-recipe-button:hover {
            background-color: #d4b8b9;
        }

        .footer {
            background: #f0eeed;
            border-top: 3px solid #dddddd;
            padding: 42px 0;
            font-size: 12px;
            color: #a5a5a5;
            width: 100%;
            text-align: center;
        }

        .footer ul {
            margin: 0;
            padding: 0;
            list-style: none;
            display: flex;
            justify-content: center;
        }

        .footer ul li {
            margin: 0 10px;
        }

        .footer ul li:after {
            content: " | ";
        }

        .footer ul li:last-child:after {
            content: "";
        }

        .footer a {
            text-decoration: none;
            color: #539def;
        }

        .footer a:hover, .footer a:active {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <h2 style= "color: black"; >Your Profile </h2>
    <div class="profile-container">
        <img src="<?php echo $user['user_image']; ?>" alt="User Image">
        <h1><?php echo $user['username']; ?></h1>
        <p><?php echo $user['email']; ?></p>
        <button class="add-recipe-button" onclick="window.location.href='add_recipe_html.php'">Add Recipe</button>
        <br>
        <br>
        <button class="add-recipe-button" onclick="window.location.href='displayRecipe.php'">My Recipes</button>

    </div>
</body>
<?php include 'footer.php'; ?>
</html>
