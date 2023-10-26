<?php 
    session_start();

    if(!isset($_SESSION["id"])) {
        header('Location: /veikals/admin/index.php');
        exit();
    }

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/Database.php';
?>

<?php
    function outputAlert ($strMsg) {
        echo "<div class='alert alert-danger'>";
            echo $strMsg;
        echo "</div>";
    }

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

                //Palaiž SQL
                if ($stmt->execute()) {
                    echo "Data inserted successfully";
                } else {
                    echo "Error inserting data: " . $stmt->errorInfo()[2];
                }
            
                Database::closeConnection($conn);

                header('Location: index.php');
                exit();
            }
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

            <form method="post" id="logout" action="">
                <div class="form-group">
                    <label for="name">Vārds</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Ievadi vārdu" 
                        value="<?php if(isset($name)) echo $name; ?>">
                    <?php
                        if(isset($name))
                            if (empty($name))
                                outputAlert("Name is required");
                    ?>
                </div>
                <div class="form-group">
                    <label for="surname">Uzvārds</label>
                    <input type="text" class="form-control" name="surname" id="surname" placeholder="Ievadi uzvārdu" 
                        value="<?php if(isset($surname)) echo $surname; ?>">
                    <?php
                        if(isset($surname))
                            if (empty($surname))
                                outputAlert("Surname is required");
                    ?>
                </div>
                <div class="form-group">
                    <label for="email">E-pasts</label>
                    <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" 
                        placeholder="name@example.com" formnovalidate="formnovalidate" value="<?php if(isset($email)) echo $email; ?>">
                    <?php
                        if(isset($email))
                            if (empty($email))
                                outputAlert("Email is not valid");
                    ?>
                </div>
            
                <input type="submit" name="save" value="Saglabāt" class="btn btn-primary execution-button">
                <input type="submit" name="back" value="Atpakaļ" class="btn btn-primary execution-button">
            </form>
        </div>
    </body>
</html>