<!DOCTYPE html>
<html>
<head>
    <style>
   .category-recipes {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    overflow: auto;
}

.category-recipes h1 {
    text-align: center;
    color: #75474a;
    margin-bottom: 30px;
}

.recipe-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); /* Creates a responsive grid with columns */
    gap: 20px; /* Space between cards */
}

.recipe-card {
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 10px;
    text-align: center;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.recipe-card:hover {
    transform: translateY(-5px);
}

.recipe-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 5px;
}

.recipe-card h3 {
    margin: 10px 0;
    font-size: 1.2em;
    color: #333;
}

.view-recipe-btn {
    display: inline-block;
    padding: 10px 20px;
    background-color: #75474a;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    margin-top: 10px;
    transition: background-color 0.3s ease;
}

.view-recipe-btn:hover {
    background-color: #5a3538;
}
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="category-recipes">
    <?php
    // Database connection
    $servername = "localhost:3306";
    $username_db = "root";
    $password_db = "";
    $dbname = "recipe_site";

    $conn = new mysqli($servername, $username_db, $password_db, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if(isset($_GET['category'])) {
        $category = $_GET['category'];
        echo "<h1>" . htmlspecialchars($category) . " Recipes</h1>";

        $sql = "SELECT recipe_id, recipe_name, recipe_image FROM recipes WHERE category_name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $category);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<div class='recipe-container'>";
            while($row = $result->fetch_assoc()) {
                echo "<div class='recipe-card'>";
                echo "<img src='" . htmlspecialchars($row["recipe_image"]) . "' alt='" . htmlspecialchars($row["recipe_name"]) . "'>";
                echo "<h3>" . htmlspecialchars($row["recipe_name"]) . "</h3>";
                echo "<a href='view_recipe.php?recipe_id=" . $row["recipe_id"] . "' class='view-recipe-btn'>View Recipe</a>";
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "<p>No recipes found in this category.</p>";
        }
    } else {
        echo "<p>No category specified.</p>";
    }
    $conn->close();
    ?>
</div>

<?php include 'footer.php'; ?>
    </body>
</html>
