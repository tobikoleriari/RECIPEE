<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ensure the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['user_type_name'] != 'Admin') {
    header("Location: recipe_owner_html.php");
    exit;
}

// Database connection
$serverName = "localhost";
$userName = "root";
$password = " ";
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

<?php include 'header.php';?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Display Users</title>
    <link rel="stylesheet" href="#"> 
    <!-- <style>
        header{
@import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');

        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #aa7d7a;
        }
        .edit-button {
            background-color: #75474a; 
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        .edit-button:hover {
            background-color: #d4b8b9;
        }
        body{
    background-image: url("background.jpg");
    .roboto-medium {
        font-family: "Roboto", sans-serif;
        font-weight: 500;
        font-style: normal;
      }
}
    </style> -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap');

        body {
            background-image: url('background.jpg');
            background-size: cover;
            background-attachment: fixed;
            font-family: 'Roboto', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        header {
            width: 100%;
            background-color:#75474a ;
            padding: 10px 20px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .user-info {
            font-weight: 500;
        }

        h2 {
            color: #fff;
            margin: 20px 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        table {
            width: 100%;
            max-width: 1000px;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #75474a;
            color: white;
            font-weight: 500;
        }

        tr:hover {
            background-color: #aa7d7a;
            color: white;
        }

        .edit-button {
            background-color: #75474a; 
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .edit-button:hover {
            background-color: #d4b8b9;
        }

        img {
            border-radius: 50%;
        }
    </style>
</head>
<body>
<header>

<div class="user-info">
    Welcome, <?php echo $_SESSION['username']; ?> 
</div>
</header>
    <h2>Registered Users</h2>
    <table>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>User Type</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
        <?php
        $servername = "localhost:3306";
        $username_db = "root";
        $password_db = "";
        $dbname = "recipe_site";

        $conn = new mysqli($servername, $username_db, $password_db, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $limit = 5; 
        if (isset($_GET["page"])) {
            $page  = $_GET["page"];
        } else {
            $page = 1;
        };
        $start_from = ($page - 1) * $limit;

        $sql = "SELECT username, email, user_type_name, user_image FROM users";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['user_type_name'] . "</td>";
                echo "<td><img src='" . $row['user_image'] . "' alt='User Image' width='50'></td>";
                echo "<td><button class='edit-button' onclick='editUser(\"" . $row['username'] . "\")'>Edit</button></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No users found</td></tr>";
        }

        $conn->close();
        ?>
    </table>
    <script>
        function editUser(username) {
            window.location.href = 'editUser.php?username=' + username;
        }
    </script>
    <?php include 'footer.php'?>
</body>
</html>
