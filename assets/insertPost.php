<?php include "head.php"; ?>
<?php
/* if (!isset($_SESSION["loggedin"]) || !$_SESSION["loggedin"] === true) {
    header("location: login.php");
    exit;
} */
$title = $writer_name = $desc = $body = "";
$title_err = $writer_name_err = $desc_err = $body_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate title
    if (empty(trim($_POST["title"]))) {
        $title_err = "Please enter a title.";
    } else {
        $title = trim($_POST["title"]);
    }

    // Validate writer name
    if (empty(trim($_POST["writer_name"]))) {
        $writer_name_err = "Please enter a writer name.";
    } else {
        $writer_name = trim($_POST["writer_name"]);
    }

    // Validate description
    if (empty(trim($_POST["desc"]))) {
        $desc_err = "Please enter a description.";
    } else {
        $desc = trim($_POST["desc"]);
    }

    // Validate body
    if (empty(trim($_POST["body"]))) {
        $body_err = "Please enter the post body.";
    } else {
        $body = trim($_POST["body"]);
    }
    // Check input errors before inserting in database
    if (empty($title_err) && empty($writer_name_err) && empty($desc_err) && empty($body_err)) {
        $sql = "INSERT INTO posts (title, writer_name, `desc`, body) VALUES (:title, :writer_name, :desc, :body)";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bindParam(":title", $param_title, PDO::PARAM_STR);
            $stmt->bindParam(":writer_name", $param_writer_name, PDO::PARAM_STR);
            $stmt->bindParam(":desc", $param_desc, PDO::PARAM_STR);
            $stmt->bindParam(":body", $param_body, PDO::PARAM_STR);
            // Set parameters
            $param_body = $body;
            $param_desc = $desc;
            $param_title = $title;
            $param_writer_name =  $writer_name;
            // Hash the password before saving it to the database
            if ($stmt->execute()) {
                // Redirect the user to the login page
                header("location: ../index.php");
            } else {
                echo "Something went wrong. Please try again later.";
                header("location: ../error.php");
            }
        } else {
            echo "Something went wrong. Please try again later.";
            header("location: ../error.php");
        }

        // Close statement
        unset($stmt);
    } else {
        echo "Something went wrong. Please try again later.";
        header("location: error.php");
    }

    // Close connection
    unset($conn);
}
