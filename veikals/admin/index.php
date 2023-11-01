<?php 
    session_start();

    if(isset($_SESSION["id"])) {
        header('Location: /veikals/admin/src/panel.php');
        exit();
    }
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/Config.php';
?>

<!DOCTYPE html>
<html lang="en">  
    <?php include 'src/head.php'; ?>
    <body>
        <h1>Welcome</h1>

        <script src="https://accounts.google.com/gsi/client" async></script>
        <div id="g_id_onload"
            data-client_id= <?php echo Config::getValue('config', 'google', 'client_id'); ?>
            data-login_uri= <?php echo Config::getValue('config', 'google', 'redirect_uri'); ?>
            data-auto_prompt="false">
        </div>
        <div class="g_id_signin"
            data-type="standard"
            data-size="medium"
            data-theme="outline"
            data-text="sign_in_with"
            data-shape="circle"
            data-logo_alignment="center">
        </div>
    </body>
</html>