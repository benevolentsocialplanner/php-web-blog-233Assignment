<link rel="stylesheet" href="css/style.css">
<header class="header">

    <img src="img/download.jpg" style="width: 6rem;">

    <?php if ($loggedin) : ?>
        <nav>
            <a href="index.php">Home</a>
        </nav>
    <?php else : ?>
        <nav>
            <a href="signup.php">Sign up</a>
        </nav>
    <?php endif;  ?>
    <a href="<?= ($loggedin) ? 'Logout.php' : 'login.php'; ?>">
        <?= ($loggedin) ? 'Logout' : 'Log in'; ?>
    </a>


</header>