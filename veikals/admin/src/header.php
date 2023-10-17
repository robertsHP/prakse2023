
<div id="username"> 
    <?php echo $_SESSION["name"]; ?>
</div>

<form action="logout.php">
    <input type="submit" name="submit" value="Logout" class="btn btn-primary">
</form>