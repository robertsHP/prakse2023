<?php
    session_start(); 

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/include/googleApiClient/vendor/autoload.php';
    require_once 'Config.php';
    require_once 'Database.php';

    if (!isset($_POST['credential'])) {
        header('Location: /veikals/admin/index.php');
        exit();
    }

    $client = new Google_Client();
    $client->setClientId(Config::getValue('config', 'google', 'client_id'));
    $client->setClientSecret(Config::getValue('config', 'google', 'client_secret'));
    $client->setRedirectUri(Config::getValue('config', 'google', 'redirect_uri'));
    $client->addScope("email");
    $client->addScope("profile");

    $payload = $client->verifyIdToken($_POST['credential']);

    if (!$payload) {
        header('Location: /veikals/admin/index.php');
        exit();
    }

    $conn = Database::getConnection();

    $stmt = $conn->prepare("SELECT * FROM user WHERE email=:email");
    $stmt->bindParam(':email', $payload['email'], PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $conn = Database::closeConnection();

    if(empty($user)) {
        header('Location: /veikals/admin/index.php');
        exit();
    }

    $_SESSION["id"] = $user['user_id'];
    $_SESSION["name"] = $user['name'];
    $_SESSION["surname"] = $user['surname'];
    $_SESSION["email"] = $user['email'];

    header('Location: /veikals/admin/src/panel.php');
    exit();
?>