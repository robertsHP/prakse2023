<?php
    session_destroy();
    session_write_close();
    setcookie(session_name(),'',0,'/');

    header('Location: /veikals/admin/index.php');
    exit();
?>