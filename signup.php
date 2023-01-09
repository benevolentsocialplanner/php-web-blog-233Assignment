<?php include "assets/head.php"; ?>
<link rel="stylesheet" href="css/style.css">
<?php

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}
?>
</head>

<body>
    <main>
        <div class="signup-form">
            <h1>Sign Up</h1>
            <form action="signup.php" method="post">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <div class="form-group">
                    <input type="submit" value="Sign Up">
                </div>
            </form>
        </div>
    </main>
    <?php

    // Check for form submission

    // Define variables and initialize with empty values
    $name = $email = $password = "";
    $name_err = $email_err = $password_err = "";

    // Processing form data when form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate name
        if (empty(trim($_POST["name"]))) {
            $name_err = "Please enter your name.";
        } else {
            // Check if name is unique
            $sql = "SELECT * FROM users WHERE name = :name";
            if ($stmt = $conn->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":name", $param_name, PDO::PARAM_STR);

                // Set parameters
                $param_name = trim($_POST["name"]);

                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    if ($stmt->rowCount() == 1) {
                        $name_err = "This name is already taken.";
                    } else {
                        $name = trim($_POST["name"]);
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
            unset($stmt);
        }

        // Validate email
        if (empty(trim($_POST["email"]))) {
            $email_err = "Please enter your email.";
        } else {
            // Check if email is unique
            $sql = "SELECT * FROM users WHERE email = :email";
            if ($stmt = $conn->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);

                // Set parameters
                $param_email = trim($_POST["email"]);

                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    if ($stmt->rowCount() == 1) {
                        $email_err = "This email is already registered.";
                    } else {
                        $email = trim($_POST["email"]);
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
            unset($stmt);
        }

        // Validate password
        if (empty(trim($_POST["password"]))) {
            $password_err = "Please enter a password.";
        } elseif (strlen(trim($_POST["password"])) < 3) {
            $password_err = "Password must have at least 8 characters.";
        } else {
            $password = trim($_POST["password"]);
        }
        // Check input errors
        if (empty($name_err) && empty($email_err) && empty($password_err)) {
            // Prepare an insert statement
            $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
            if ($stmt = $conn->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":name", $param_name, PDO::PARAM_STR);
                $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
                $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);

                // Set parameters
                $param_name = $name;
                $param_email = $email;
                // Hash the password before saving it to the database
                $param_password = password_hash($password, PASSWORD_DEFAULT);

                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    // Redirect the user to the login page
                    header("location: index.php");
                } else {
                    echo "Something went wrong. Please try again later.";
                    header("location: error.php");
                }
            } else {
                echo "Something went wrong. Please try again later.";
                header("location: error.php");
            }

            // Close statement
            unset($stmt);
        } else {
            echo "Something went wrong. Please try again later.";
            header("location: error.php");
        }

        // Close connection
        unset($conn);
    } ?>
    <?php include "assets/footer.php" ?>
</body>

</html>