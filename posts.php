<?php include "assets/head.php";

if (!$loggedin) {
    header("location: index.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM posts");
$stmt->execute();
$categories = $stmt->fetchAll();
?>
<title>posts</title>
<link type="text/css" rel="stylesheet" href="css/style.css" />

</head>

<body>
    <main>
        <?php include "assets/header.php" ?>

        <div class="row">
            <table class='table '>

                <thead class='thead'>
                    <tr>
                        <th scope='col'>title</th>
                        <th scope='col'>desc</th>
                        <th scope='col'>body</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    foreach ($posts as $post) :
                        echo "<tr>";
                    ?>
                        <td><?= $post['title'] ?></td>
                        <td><?= $post['desc'] ?></td>

                    <?php
                        echo "</tr>";
                    endforeach;
                    ?>
                </tbody>

            </table>
        </div>
    </main>
    <?php include "assest/footer.php" ?>


</body>

</html>