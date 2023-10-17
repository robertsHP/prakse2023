
<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/prakse/veikals/include/googleApiClient/vendor/autoload.php';
    require_once 'Database.php';

    if (!isset($_POST['credential']))
        header('Location: /prakse/veikals/admin/index.php');

    $client = new Google_Client();
    $client->setClientId(Database::$clientID);
    $client->setClientSecret(Database::$clientSecret);
    $client->setRedirectUri(Database::$redirectUri);
    $client->addScope("email");
    $client->addScope("profile");

    $payload = $client->verifyIdToken($_POST['credential']);

    if (!$payload)
        header('Location: /prakse/veikals/admin/index.php');

    $conn = Database::getConnection();

    $stmt = $conn->prepare("SELECT * FROM user WHERE email=:email");
    $stmt->bindParam(':email', $payload['email'], PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if(empty($user))
        header('Location: /prakse/veikals/admin/index.php');

    session_start();

    $_SESSION["id"] = $user['user_id'];
    $_SESSION["name"] = $user['name'];
    $_SESSION["surname"] = $user['surname'];
    $_SESSION["email"] = $user['email'];
?>