<?php 
    session_start();

    if(!isset($_SESSION["id"])) {
        header('Location: /veikals/admin/index.php');
        exit();
    }

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/Database.php';
?>

<?php
    if (!isset($_SESSION["id"])) {
        header('Location: index.php');
        exit();
    }

    $conn = Database::openConnection();

    $stmt = $conn->prepare("SELECT * FROM user WHERE user_id=:id");
    $stmt->bindParam(':id', $_SESSION["id"], PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    Database::closeConnection($conn);
    
    if(empty($result)) {
        header('Location: index.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">  
    <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/head.php'; ?>
    <body>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/header.php'; ?>

        <div class="container">
            <h4 id="page-title">Lietotāja informācija</h4>
            <div>
                ID: <?php echo $_SESSION["id"] ?>
            </div>
            <div>
                Name: <?php echo $_SESSION["name"] ?>
            </div>
            <div>
                Surname: <?php echo $_SESSION["surname"] ?>
            </div>
            <div>
                Email: <?php echo $_SESSION["email"] ?>
            </div>
        </div>
    </body>
</html>