<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Add Recipe</title>
  <link rel="stylesheet" href="add_recipe.css"> </head>
<body>
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
        <textarea id="recipe_steps" name="recipe_steps" required></textarea>
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
                $servername = "localhost:3307";
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
</body>
</html>
