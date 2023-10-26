<?php 
    session_start();

    if(!isset($_SESSION["id"])) {
        header('Location: /veikals/admin/index.php');
        exit();
    }

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/Database.php';
?>

<?php
    //Apstrādā formā ievadīto informāciju
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['save'])) {
            $name = $_POST['name'];
            $surname = $_POST['surname'];
            $email = $_POST['email'];

            if (!empty($surname) && !empty($surname) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $conn = Database::openConnection();

                //Sagatavo SQL
                $stmt = $conn->prepare("INSERT INTO user (name, surname, email) VALUES (:name, :surname, :email)");

                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':surname', $surname, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->execute();

                Database::closeConnection($conn);
            }
            header('Location: index.php');
            exit();
        } else if (isset($_POST['back'])) {
            header('Location: index.php');
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">  
    <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/head.php'; ?>
    <body>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/header.php'; ?>
        <div class="container">
            <h4 id="page-title">Izveidot jaunu lietotāju</h4>

            <form method="post" action="">
                <?php include 'form.php'; ?>
                <input type="submit" name="save" value="Saglabāt" class="btn btn-primary execution-button">
                <input type="submit" name="back" value="Atpakaļ" class="btn btn-primary execution-button">
            </form>
        </div>
    </body>
</html>