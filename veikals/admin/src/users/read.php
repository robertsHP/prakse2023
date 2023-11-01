<?php 
    $redirect = '/veikals/admin/index.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/sessionCheck.php';
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/Database.php';
?>

<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['back'])) {
            header('Location: index.php');
            exit();
        }
    }

    $id = null;
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    } else if (isset($_SESSION["id"])) {
        $id = $_SESSION["id"];
    } else {
        header('Location: index.php');
        exit();
    }

    if(isset($id)) {
        $conn = Database::openConnection();

        $stmt = $conn->prepare("SELECT * FROM user WHERE user_id=:id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

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

                    <div class="main-container">
                        <h4>Lietotāja informācija</h4>
                        <table class="table table-hover">
                            <tr>
                                <th>ID: </th>
                                <th><?php echo $result['user_id'] ?></th>
                            </tr>
                            <tr>
                                <th>Vārds: </th>
                                <th><?php echo $result['name'] ?></th>
                            </tr>
                            <tr>
                                <th>Uzvārds: </th>
                                <th><?php echo $result['surname'] ?></th>
                            </tr>
                            <tr>
                                <th>E-pasts: </th>
                                <th><?php echo $result['email'] ?></th>
                            </tr>
                        </table>
                        <form method="post" action="">
                            <input type="submit" name="back" value="Atpakaļ" class="btn btn-primary execution-button">
                        </form>
                    </div>
                </body>
            </html>
        <?php
    }
?>