<?php
session_start();
if (!isset($_SESSION['current_session'])) header('Location: ../index.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue</title>
</head>
<body>
    <?php echo "<h1>Bienvenue " . $_SESSION['current_session']['user']['id'] . "</h1>"; ?>
    <a href="logout.php">Se déconnecter</a>
</body>
</html>