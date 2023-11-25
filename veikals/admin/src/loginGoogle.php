<?php
    session_start(); 

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/include/googleApiClient/vendor/autoload.php';

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/users/data.php';

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/Config.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/Database.php';

    $usersTableName = $tableName;
    $usersIDColumnName = $idColumnName;

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

    $row = Database::getRowFrom(
        $usersTableName, 
        'email', 
        $payload['email'], 
        PDO::PARAM_STR);

    if(empty($row)) {
        header('Location: /veikals/admin/index.php');
        exit();
    }

    $_SESSION["id"] = $row[$usersIDColumnName];
    $_SESSION["name"] = $row['name'];
    $_SESSION["surname"] = $row['surname'];
    $_SESSION["email"] = $row['email'];

    header('Location: /veikals/admin/src/panel.php');
    exit();
?>