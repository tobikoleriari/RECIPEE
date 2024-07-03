<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ensure the user is logged in and is a recipe owner
if (!isset($_SESSION['username']) || $_SESSION['user_type_name'] != 'Recipe Owner') {
    header("Location: landingpage.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Add Recipe</title>
  <link rel="stylesheet" href="add_recipe.css"> </head>
<body>
<header>

        <div class="user-info">
            Welcome, <?php echo $_SESSION['username']; ?> 
        </div>
    </header>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Roboto', sans-serif;
}

body {
    display: flex;
    flex-direction: column; /* Changed to column to allow vertical scroll */
    justify-content: flex-start; /* Changed to flex-start to align items at the top */
    align-items: center;
    min-height: 100vh;
    background-image: url(loginpic.jpg);
    overflow-y: auto; /* Changed to auto to allow vertical scrolling */
    padding: 20px; /* Added padding to create some space around the content */
}

.recipe-box {
    width: 100%;
    max-width: 600px; /* Changed width to max-width for better responsiveness */
    background: #75474a;
    border-radius: 20px;
    padding: 20px; /* Added padding for better spacing */
    margin: 20px 0; /* Added margin to create space around the box */
}

h2 {
    font-size: 2em;
    color: #fff;
    text-align: center;
    margin-bottom: 20px; /* Added margin to create space below the heading */
}

.input-box, .input-box-file {
    position: relative;
    width: 100%; /* Changed width to 100% for better responsiveness */
    margin: 10px 0; /* Adjusted margin for better spacing */
}

.input-box .input-line {
    position: absolute;
    bottom: 0; /* Adjusted bottom to align the line properly */
    left: 0;
    width: 100%;
    height: 2px;
    background: #fff;
    transition: .5s ease;
}

.input-box label, .input-box-file label {
    position: absolute;
    top: 50%;
    left: 5px;
    transform: translateY(-50%);
    font-size: 1em;
    color: #fff;
    pointer-events: none;
    transition: .5s ease;
}

.input-box input:focus ~ label,
.input-box input:valid ~ label,
.input-box:hover label,
.input-box-file input:focus ~ label,
.input-box-file input:valid ~ label,
.input-box-file:hover label {
    top: -10px; /* Adjusted top position for better alignment */
    font-size: 0.8em; 
    color: #aaa; 
}

.input-box input, .input-box-file input {
    width: 100%;
    height: 40px; /* Adjusted height for better spacing */
    background: transparent;
    border: none;
    outline: none;
    font-size: 1em;
    color: #fff;
    padding: 10px 5px; /* Adjusted padding for better spacing */
}

.input-box-file label.upload-button {
    display: block;
    width: 100%;
    height: 40px; /* Adjusted height for consistency */
    background: transparent;
    border: 1px solid #fff;
    border-radius: 5px; /* Adjusted border-radius for consistency */
    cursor: pointer;
    text-align: center;
    line-height: 40px; /* Adjusted line-height for better vertical alignment */
    transition: .5s ease;
}

.input-box-file label.upload-button:hover {
    background-color: rgba(255, 255, 255, 0.1);
}

button {
    width: 100%;
    height: 40px;
    background: #fff;
    border: none;
    outline: none;
    border-radius: 20px; /* Adjusted border-radius for consistency */
    cursor: pointer;
    font-size: 1em;
    color: #191919;
    font-weight: 500;
    transition: .5s ease;
    margin-top: 20px; /* Added margin to create space above the button */
}

.login-link {
    color: #fff;
    font-size: .9em;
    text-align: center;
    margin: 25px 0 10px;
    transition: .5s ease;
}

.login-link p a {
    color: #fff;
    text-decoration: none;
    font-weight: 600;
    transition: color .5s ease;
}

.login-link p a:hover {
    text-decoration: underline;
}

  </style>
<div class="recipe-box"> 

    <form action="add_recipe.php" method="post" enctype="multipart/form-data">
    <h2 >Add Recipe</h2>
      <div class="input-box">
        <label for="recipe_name">Recipe Name:</label>
        <input type="text" id="recipe_name" name="recipe_name" required>
        <div class="input-line"></div>
      </div>
      <p style="color: #fff;">Ingredients</p>
      <div class="input-box">
        <!-- <label  style="color:#75474a ;" for="ingredients">Ingredients:</label> -->
        <textarea id="ingredients" name="ingredients" required></textarea>
        <!-- <div class="input-line"></div> -->
      </div>
      <p style="color: #fff;">Steps</p>
      <div class="input-box">
        <textarea id="steps" name="steps" required></textarea>
      </div>
      <p style="color: #fff;">Upload image</p>
      <div class="input-box">
        <!-- <label for="recipe_image">Upload Image:</label> -->
        <input type="file" id="recipe_image" name="recipe_image" required>  
        <div class="input-line"></div>
      </div>
      <div class="input-box">
        <label for="recipe_owner">Recipe Owner (User ID):</label>
        <input type="text" id="recipe_owner" name="recipe_owner" required>
        <div class="input-line"></div>
      </div>
      <div class="input-box">
        <!-- <label for="category_id">Category name:</label> -->
        <!-- <label for="category_id">Category:</label> -->
            <select id="category_name" name="category_name">
                <!-- Dynamically populate options with categories from the database -->
                <?php
                $servername = "localhost:3306";
                $username_db = "root";
                $password_db = "";
                $dbname = "recipe_site";

            $conn = new mysqli($servername, $username_db, $password_db, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT category_name FROM categories";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value=\"" . $row['category_name'] . "\">" . $row['category_name'] . "</option>";
                }
            } else {
                echo "<option value=\"\">No categories available</option>";
            }

            $conn->close();
            ?>
            </select><br>
      </div>
      <button type="submit">Add Recipe</button>
    </form>
  </div>
  <br>
  <br>

  <?php include 'footer.php'?>
</body>
</html>
