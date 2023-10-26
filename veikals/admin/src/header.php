
<div id="header">
    <div>
        <a href="/veikals/admin/src/panel.php">Panelis</a>
    </div>
    <div>
        <div id="username"><?php echo $_SESSION["name"]; ?></div>
        <form id="logout" action="/veikals/admin/src/logout.php">
            <input type="submit" name="logout" value="Iziet" class="btn btn-primary execution-button">
        </form>
    </div>
</div>