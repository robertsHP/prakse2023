
<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/prakse/veikals/include/googleApiClient/vendor/autoload.php';
    require_once 'Database.php';

    if (isset($_POST['idtoken'])) {
        $client = new Google_Client(['client_id' => Database::$clientID]);  // Specify the CLIENT_ID of the app that accesses the backend
        $payload = $client->verifyIdToken($_POST['idtoken']);
        if ($payload) {
            $userid = $payload['sub'];
            $email = $payload['email'];

            $conn = Database::getConnection();

            $stmt = $conn->prepare(
                "SELECT * FROM user WHERE email=:email"
            );
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            echo "Invalid ID token";
        }
    }
?>