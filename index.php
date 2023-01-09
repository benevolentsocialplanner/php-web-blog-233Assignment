<?php include "assets/head.php";

?>
<link rel="stylesheet" href="css/style.css">

<title>Home</title>
</head>

<body>

    <?php include "assets/header.php" ?>

    <?php
    // Get all posts from the database
    $stmt = $conn->prepare("SELECT * FROM posts");
    $stmt->execute();
    $result = $stmt->fetchAll();
    ?> <?php
        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        ?><a href="add_post.php">add a post</a><?php
                                                if ($stmt->rowCount() > 0) {

                                                    // Output the results
                                                    foreach ($result as $row) {
                                                        echo "<div class='post'>";
                                                        echo "<h2>" . $row['title'] . "</h2>";
                                                        echo "<p>" . $row['body'] . "</p>";
                                                        echo "<p>" . $row['desc'] . "</p>";
                                                        echo "</div>";
                                                    }
                                                } else {
                                                    echo "No posts found";
                                                }
                                            }
                                                ?>
    <?php
    if (!isset($_SESSION["loggedin"]) || !$_SESSION["loggedin"] === true) {
    ?> <span>log in to see the posts</span><?php
                                        }
                                            ?>

    <?php include "assets/footer.php" ?>
</body>

</html>