<?php
$servername = "localhost:3307";
$username_db = "root";
$password_db = "";
$dbname = "recipe_site";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql ="Select* from users";
$result = $conn-> query($sql);
print_r($result);
while ($row = $result->fetch_assoc()) {
  printf("%s (%s)\n", $row["users"]);

}
?>