<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>Registration Page</title>
    <link rel="stylesheet" href="register.css" />
  </head>
<body>
    <div class="register-box">
        <form action="register.php" method="post" enctype="multipart/form-data">
            <h2>Register</h2>
            <div class="input-box">
                <input type="text" name="username" id="username" required />
                <label>Username</label>
                <div class="input-line"></div>
            </div>
            <div class="input-box">
                <input type="email" name="email" id="email" required />
                <label>Email</label>
                <div class="input-line"></div>
            </div>
            <div class="input-box">
                <input type="password" name="password" id="password" required />
                <label>Password</label>
                <div class="input-line"></div>
            </div>
            <div class="input-box">
                <input type="password" name="confirm_password" id="confirm_password" required />
                <label>Confirm Password</label>
                <div class="input-line"></div>
            </div>
            <p style="color: #fff">Upload image</p>
            <div class="input-box">
                <input type="file" id="user_image" name="user_image" /><br /><br />
                <label for="user_image"></label>
                <div class="input-line"></div>
            </div>
            <div class="input-box">
                <select  id ="user_type_name" name="user_type_name">
                    <?php
                    $servername = "localhost:3306";
                    $username_db = "root";
                    $password_db = "";
                    $dbname = "recipe_site";

                    $conn = new mysqli($servername, $username_db, $password_db, $dbname);

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SELECT user_type_name FROM user_types";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value=\"" . $row['user_type_name'] . "\">" . $row['user_type_name'] . "</option>";
                        }
                    } else {
                        echo "<option value=\"\">No user types available</option>";
                    }

                    $conn->close();
                    ?>
                </select><br>
            </div>
            <button type="submit">Register</button>
            <div class="login-link">
                <p>Already have an account? <a href="login.html">Login</a></p>
            </div>
        </form>
    </div>
    <!-- <?php include 'footer.php'?> -->
</body>
</html>
  <!-- <body>
    <div class="register-box">
      <form action="register.php" method="post" enctype="multipart/form-data">
        <h2>Register</h2>
        <div class="input-box">
          <input type="text" name="username" id="username" required />
          <label>Username</label>
          <div class="input-line"></div>
        </div>
        <div class="input-box">
          <input type="email" name="email" id="email" required />
          <label>Email</label>
          <div class="input-line"></div>
        </div>
        <div class="input-box">
          <input type="password" name="password" id="password" required />
          <label>Password</label>
          <div class="input-line"></div>
        </div>
        <div class="input-box">
          <input  type="password"name="confirm_password" id="confirm_password" required />
          <label>Confirm Password</label>
          <div class="input-line"></div>
        </div>
        <p style="color: #fff">Upload image</p>
        <div class="input-box">
          <input type="file" id="user_image" name="user_image" /><br /><br />
          <label for="user_image"></label>
          <div class="input-line"></div>
        </div>
        <div class="input-box">
                <select name="user_type">
                    <?php
                    // $conn = new mysqli($servername, $username_db, $password_db, $dbname);

                    // if ($conn->connect_error) {
                    //     die("Connection failed: " . $conn->connect_error);
                    // }

                    // $sql = "SELECT user_type_name FROM user_types";
                    // $result = $conn->query($sql);

                    // if ($result->num_rows > 0) {
                    //     while ($row = $result->fetch_assoc()) {
                    //         $selected = $row['user_type_name'] == $user['user_types'] ? "selected" : "";
                    //         echo "<option value=\"" . $row['user_type_name'] . "\" $selected>" . $row['user_type_name'] . "</option>";
                    //     }
                    // } else {
                    //     echo "<option value=\"\">No user types available</option>";
                    // }

                    // $conn->close();
                    ?>
                </select><br>
            </div>
        <button type="submit">Register</button>
        <div class="login-link">
          <p>Already have an account? <a href="login.html">Login</a></p>
        </div>
      </form>
    </div>
  </body>
</html> -->
