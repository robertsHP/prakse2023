<?php
    $client = null;
    $payload = null;

    // remove all session variables
    session_unset();
    // destroy the session
    session_destroy();

    header('Location: /prakse/veikals/admin/index.php');
?>