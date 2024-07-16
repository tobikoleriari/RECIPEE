<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

$serverName = "localhost";
$userName = "root";
$password = "";
$dbName = "recipe_site";

$conn = new mysqli($serverName, $userName, $password, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['recipe_id'])) {
    $recipe_id = $_GET['recipe_id'];
    $query = "SELECT * FROM recipes WHERE recipe_id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $recipe_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $recipe = $result->fetch_assoc();
    $stmt->close();
    
    if (!$recipe) {
        echo "Recipe not found.";
        exit;
    }
} else {
    echo "No recipe ID provided.";
    exit;
}

$conn->close();
?>

<?php include 'header.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($recipe['recipe_name']); ?></title>
    <style>
        body {
            font-family: Roboto, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #75474a;
            text-align: center;
            margin-bottom: 20px;
        }
        img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .recipe-info {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        h2 {
            color: #75474a;
            border-bottom: 2px solid #75474a;
            padding-bottom: 10px;
            margin-top: 30px;
        }
        ul, ol {
            padding-left: 20px;
        }
        li {
            margin-bottom: 10px;
        }
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #75474a;
            text-decoration: none;
            font-weight: bold;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="landingpage.php" class="back-link">← Back to Recipes</a>
        <h1><?php echo htmlspecialchars($recipe['recipe_name']); ?></h1>
        <img src="<?php echo htmlspecialchars($recipe['recipe_image']); ?>" alt="<?php echo htmlspecialchars($recipe['recipe_name']); ?>">
        
        <!-- <div class="recipe-info">
            <p><strong>Category:</strong> <?php echo htmlspecialchars($recipe['category_name']); ?></p>
        </div> -->

        <h2>Ingredients:</h2>
        <ul>
            <?php 
            $ingredients = explode("\n", $recipe['ingredients']);
            foreach ($ingredients as $ingredient) {
                echo "<li>" . htmlspecialchars(trim($ingredient)) . "</li>";
            }
            ?>
        </ul>

        <h2>Steps:</h2>
        <ul>
            <?php 
            $steps = explode("\n", $recipe['steps']);
            foreach ($steps as $step) {
                echo "<li>" . htmlspecialchars(trim($step)) . "</li>";
            }
            ?>
        </ul>
    </div>
</body>
</html>