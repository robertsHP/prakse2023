<?php 
    session_start();

    if(!isset($_SESSION["id"])) {
        header('Location: /veikals/admin/index.php');
        exit();
    }

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/Database.php';
?>

<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['save'])) {
            $errors = array();

            $name = $_POST['name'];
            $surname = $_POST['surname'];
            $email = $_POST['email'];
            
            if (empty($name))
                $errors[] = "Name is required.";
            if (empty($surname))
                $errors[] = "Surname is required.";
            
            // Pārbauda e-pastu
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email is not valid.";
            }

            if (empty($errors)) {
                $conn = Database::getConnection();

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
            
                $conn = Database::closeConnection();

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
                    <input type="text" class="form-control" name="name" id="name" placeholder="Ievadi vārdu">
                </div>
                <div class="form-group">
                    <label for="surname">Uzvārds</label>
                    <input type="text" class="form-control" name="surname" id="surname" placeholder="Ievadi uzvārdu">
                </div>
                <div class="form-group">
                    <label for="email">E-pasts</label>
                    <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="name@example.com">
                </div>

                <?php
                    // Display errors if any
                    if (!empty($errors)) {
                        echo "<div class='alert alert-danger'>";
                        foreach ($errors as $error) {
                            echo $error . "<br>";
                        }
                        echo "</div>";
                    }
                ?>
            
                <input type="submit" name="save" value="Saglabāt" class="btn btn-primary execution-button">
                <input type="submit" name="back" value="Atpakaļ" class="btn btn-primary execution-button">
            </form>
        </div>
    </body>
</html>