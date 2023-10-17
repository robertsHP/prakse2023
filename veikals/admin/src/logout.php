<?php
    $client = null;
    $payload = null;

    // remove all session variables
    session_unset();
    // destroy the session
    session_destroy();

    header('Location: /veikals/admin/index.php');
?>