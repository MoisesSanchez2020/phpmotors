<?php
    // If the current user doesn't have a session set, is not logged in, or is not an admin, redirect to home view.
    if(!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'] || $_SESSION['clientData']['clientLevel'] < 2) {
        header('Location: /phpmotors/');
        exit;
    }
    // Set the session message into the $message variable
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vehicle Management | PHP Motors</title>
    <link rel="stylesheet" href="/phpmotors/css/main.css" media="screen">
</head>

<body>
    <div class="site-wrapper">
        <header>
            <?php include $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/header.php'; ?>
        </header>
        <nav>
            <?php echo $navList; ?>
        </nav>
        <main>
            <h1>Vehicle Management</h1>
            <ul>
                <li><a href="../vehicles/index.php?action=new-classification">Add Classification</a></li>
                <li><a href="../vehicles/index.php?action=new-vehicle">Add Vehicle</a></li>
            </ul>
            <?php
                if (isset($_SESSION['message'])) {
                    $message = $_SESSION['message'];
                }
                if (isset($message)) {
                    echo $message;
                }
                unset($_SESSION['message']);

                if (isset($classificationList)) { 
                    echo '<h2>Vehicles By Classification</h2>'; 
                    echo '<p>Choose a classification to see those vehicles</p>'; 
                    echo $classificationList; 
                }
            ?>
            <noscript>
                <p><strong>JavaScript Must Be Enabled to Use this Page.</strong></p>
            </noscript>
            <table id="inventoryDisplay"></table>
        </main>
        <footer>
        <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'
        ?>
        </footer>
    </div>
    <script src="../js/inventory.js"></script>
</body>

</html>