<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is logged in and has the correct user type
if (!isset($_SESSION['username']) || $_SESSION['user_type_name'] != 'Recipe Owner') {
    header("Location: landingpage.php");
    exit;
}

$servername = "localhost:3306";
$username_db = "root";
$password_db = "";
$dbname = "recipe_site";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$recipe = null;
$recipe_id = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recipe_id = $_POST['recipe_id'];
    $recipe_name = $_POST['recipe_name'];
    $category_name = $_POST['category_name'];
    $steps = $_POST['steps'];
    $ingredients = $_POST['ingredients'];

    // Initialize $recipe_image to null
    $recipe_image = null;

    // Check if directory exists, if not, create it
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Handle file upload for recipe image
    if (isset($_FILES['recipe_image']) && $_FILES['recipe_image']['error'] == UPLOAD_ERR_OK) {
        $recipe_image = $target_dir . basename($_FILES['recipe_image']['name']);
        if (!move_uploaded_file($_FILES['recipe_image']['tmp_name'], $recipe_image)) {
            echo "Failed to upload image.";
            exit();
        }
    }

    // Update recipe in database
    if ($recipe_image) {
        $sql = "UPDATE recipes SET recipe_name=?, category_name=?, steps=?, ingredients=?, recipe_image=? WHERE recipe_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $recipe_name, $category_name, $steps, $ingredients, $recipe_image, $recipe_id);
    } else {
        $sql = "UPDATE recipes SET recipe_name=?, category_name=?, steps=?, ingredients=? WHERE recipe_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $recipe_name, $category_name, $steps, $ingredients, $recipe_id);
    }

    if ($stmt->execute()) {
        echo "Recipe updated successfully!";
        header("Location: displayRecipe.php");
        exit();
    } else {
        echo "Error updating recipe: " . $stmt->error;
    }

    $stmt->close();
} elseif (isset($_GET['recipe_id'])) {
    $recipe_id = $_GET['recipe_id'];
    $sql = "SELECT * FROM recipes WHERE recipe_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $recipe_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $recipe = $result->fetch_assoc();
    $stmt->close();

    if (!$recipe) {
        echo "Recipe not found.";
        exit();
    }
} else {
    echo "Recipe ID not provided.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Recipe</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <div class="register-box">
        <form action="editRecipe.php" method="post" enctype="multipart/form-data">
            <h2>Edit Recipe</h2>
            <input type="hidden" name="recipe_id" value="<?php echo htmlspecialchars($recipe_id); ?>" />
            <div class="input-box">
                <input type="text" name="recipe_name" value="<?php echo htmlspecialchars($recipe['recipe_name'] ?? ''); ?>" required />
                <label>Recipe Name</label>
                <div class="input-line"></div>
            </div>
            <p style="color: #fff;">Ingredients</p>
            <div class="input-box">
                <textarea name="ingredients" required><?php echo htmlspecialchars($recipe['ingredients'] ?? ''); ?></textarea>
            </div>
            <p style="color: #fff;">Steps</p>
            <div class="input-box">
                <textarea name="steps" required><?php echo htmlspecialchars($recipe['steps'] ?? ''); ?></textarea>
            </div>
            <p style="color: #fff;">Category</p>
            <div class="input-box">
                <select name="category_name">
                    <?php
                    $sql = "SELECT category_name FROM categories";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $selected = $row['category_name'] == ($recipe['category_name'] ?? '') ? "selected" : "";
                            echo "<option value=\"" . htmlspecialchars($row['category_name']) . "\" $selected>" . htmlspecialchars($row['category_name']) . "</option>";
                        }
                    } else {
                        echo "<option value=\"\">No categories available</option>";
                    }
                    ?>
                </select><br>
            </div>
            <div class="input-box">
                <input type="file" name="recipe_image" /><br /><br />
                <label for="recipe_image"></label>
                <div class="input-line"></div>
            </div>
            <button type="submit">Update Recipe</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>