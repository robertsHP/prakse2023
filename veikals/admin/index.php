<!DOCTYPE html>
<html lang="en">  
    <?php
        include 'src/head.php';
        require_once 'src/Database.php';
    ?>
    <body>
        <h1>Welcome</h1>

        <script src="https://accounts.google.com/gsi/client" async></script>
        <div id="g_id_onload"
            data-client_id= <?php echo Database::$clientID; ?>
            data-login_uri= <?php echo Database::$redirectUri; ?>
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