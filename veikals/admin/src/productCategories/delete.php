<?php 
    $redirect = '/veikals/admin/index.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/sessionCheck.php';
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/Database.php';
?>

<?php
    //Pārbauda vai tika padots ID
    if (!isset($_GET['id'])) {
        header('Location: index.php');
        exit();
    }
    $id = $_GET['id'];

    //Atrod lietotāju datubāzē
    $conn = Database::openConnection();

    $stmt = $conn->prepare("SELECT * FROM product_category WHERE category_id=:id");
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    Database::closeConnection($conn);
    
    //Ja nav nekas tad veic redirect uz index
    if(empty($result)) {
        header('Location: index.php');
        exit();
    }

    //Apstrādā formā ievadīto informāciju
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['delete'])) {
            $conn = Database::openConnection();

            $stmt = $conn->prepare("DELETE FROM product_category WHERE category_id = :id");
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
        
        <div class="main-container">
            <h4>Vai tiešām vēlaties dzēst ierakstu?</h4>

            <form method="post" action="">
                <input type="submit" name="back" value="Atpakaļ" class="btn btn-outline-primary execution-button">
                <input type="submit" name="delete" value="Dzēst" class="btn btn-danger execution-button">
            </form>
        </div>
    </body>
</html>