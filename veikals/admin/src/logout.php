<?php
    session_unset();
    session_destroy();
    session_write_close();
    setcookie(session_name(),'',0,'/');
    session_regenerate_id(true);

    header('Location: /veikals/admin/index.php');
    exit();
?>