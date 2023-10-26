<?php 
    session_start();

    if(!isset($_SESSION["id"])) {
        header('Location: /veikals/admin/index.php');
        exit();
    }

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/Database.php';
?>

<?php
    if (!isset($_GET['id'])) {
        header('Location: index.php');
        exit();
    }
    $id = $_GET['id'];

    $conn = Database::openConnection();

    $stmt = $conn->prepare("SELECT * FROM user WHERE user_id=:id");
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    Database::closeConnection($conn);
    
    if(empty($result)) {
        header('Location: index.php');
        exit();
    }

    //Apstrādā formā ievadīto informāciju
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['delete'])) {
            $conn = Database::openConnection();

            $stmt = $conn->prepare("DELETE FROM user WHERE user_id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            Database::closeConnection($conn);
            header('Location: index.php');
        } else if (isset($_POST['back'])) {
            header('Location: index.php');
        }
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">  
    <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/head.php'; ?>
    <body>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/header.php'; ?>
        <div class="container">
            <h4 id="page-title">Vai tiešām vēlaties dzēst ierakstu?</h4>

            <form method="post" action="">
                <input type="submit" name="delete" value="Dzēst" class="btn btn-primary execution-button">
                <input type="submit" name="back" value="Atpakaļ" class="btn btn-primary execution-button">
            </form>
        </div>
    </body>
</html>