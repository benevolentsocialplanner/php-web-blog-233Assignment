<?php include "assets/head.php"; ?>
<?php

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}

// Define variables and initialize with empty values
$name = $password = $hashed_password = "";
$name_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter username.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($name_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT * FROM users WHERE name = :name";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":name", $param_name, PDO::PARAM_STR);

            // Set parameters
            $param_name = trim($_POST["name"]);


            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Check if username exists, if yes then verify password
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        $name = $row["name"];
                        $hashed_password = $row["password"];
                        $crypted = password_hash($password, PASSWORD_DEFAULT);
                        if (password_verify($password, $crypted)) {
                            // Password is correct, so start a new session
                            session_start();
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["name"] = $name;

                            // Redirect user to welcome page
                            header("location: index.php");
                        } else {

                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else {
                    // Display an error message if username doesn't exist
                    $name_err = "No account found with that username.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }

    // Close connection
    unset($pdo);
}
?>

<title>Login</title>
</head>

<body>
    <?php include "assets/header.php" ?>
    <div class="wrapper">

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="name" <?= (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="">
                <span class="invalid-feedback"><?= $name_err; ?></span>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" <?= (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?= $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" value="Login">
            </div>
            <p><a href="#" class="text-muted">Lost your password?</a></p>
        </form>
    </div>

    <?php include "assets/footer.php" ?>
</body>

</html>