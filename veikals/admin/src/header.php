
<div id="header">
    <div id="username"><?php echo $_SESSION["name"]; ?></div>
    <form id="logout" action="/veikals/admin/src/logout.php">
        <input type="submit" name="submit" value="Logout" class="btn btn-primary">
    </form>
</div>