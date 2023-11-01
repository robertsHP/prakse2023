<header>
    <ul>
        <li><a href="/veikals/admin/src/panel.php">Panelis</a></li>
        <li><a href="/veikals/admin/src/users/read.php">Konts</a></li>
    </ul>
    <div>
        <p><?php if(isset($_SESSION["name"])) echo $_SESSION["name"]; ?></p>
        <form id="logout" action="/veikals/admin/src/logout.php">
            <input type="submit" name="logout" value="Iziet" class="btn btn-primary execution-button">
        </form>
    </div>
</header>