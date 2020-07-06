<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $classificationName; ?> vehicles | PHP Motors</title>
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
            <h1><?php echo $classificationName; ?> vehicles</h1>
            <?php 
                if(isset($message)){
                    echo $message; 
                }
            ?>
            <?php 
                if(isset($vehicleDisplay)){
                    echo $vehicleDisplay;
                } 
            ?>
        </main>
        <footer>
        <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'
        ?>
        </footer>
    </div>
</body>

</html>