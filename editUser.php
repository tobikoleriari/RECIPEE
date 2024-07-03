<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link rel="stylesheet" href="register.css"> 
</head>
<body>
    <?php
    $servername = "localhost:3306";
    $username_db = "root";
    $password_db = "";
    $dbname = "recipe_site";

    $conn = new mysqli($servername, $username_db, $password_db, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $user_type = $_POST['user_type_name'];
        $user_image = $_FILES['user_image'];

        if (isset($_FILES['user_image']) && $_FILES['user_image']['error'] == UPLOAD_ERR_OK) {
            $user_image = 'user_pics/' . basename($_FILES['user_image']['name']);
            move_uploaded_file($_FILES['user_image']['tmp_name'], $user_image);
        }

        $sql = "UPDATE users SET email=?, user_type_name=?, user_image=? WHERE username=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $email, $user_type, $user_image, $username);

        if ($stmt->execute()) {
            echo "User updated successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $stmt->close();
        $conn->close();
        header("Location: displayUsers.php");
        exit();
    } else {
        $username = $_GET['username'];
        $sql = "SELECT * FROM users WHERE username=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        $stmt->close();
        $conn->close();
    }
    ?>
    <div class="register-box">
        <form action="editUser.php" method="post" enctype="multipart/form-data">
            <h2>Edit User</h2>
            <input type="hidden" name="username" value="<?php echo $user['username']; ?>" />
            <div class="input-box">
                <input type="email" name="email" value="<?php echo $user['email']; ?>" required />
                <label>Email</label>
                <div class="input-line"></div>
            </div>
            <div class="input-box">
                <select name="user_type">
                    <?php
                    $conn = new mysqli($servername, $username_db, $password_db, $dbname);

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SELECT user_type_name FROM user_types";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $selected = $row['user_type_name'] == $user['user_types'] ? "selected" : "";
                            echo "<option value=\"" . $row['user_type_name'] . "\" $selected>" . $row['user_type_name'] . "</option>";
                        }
                    } else {
                        echo "<option value=\"\">No user types available</option>";
                    }

                    $conn->close();
                    ?>
                </select><br>
            </div>
            <div class="input-box">
                <input type="file" name="user_image" /><br /><br />
                <label for="user_image"></label>
                <div class="input-line"></div>
            </div>
            <button type="submit">Update User</button>
        </form>
    </div>
</body>
</html>
