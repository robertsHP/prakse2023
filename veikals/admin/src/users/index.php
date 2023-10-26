<?php 
    session_start();

    if(!isset($_SESSION["id"])) {
        header('Location: /veikals/admin/index.php');
        exit();
    }

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/Database.php';
?>

<!DOCTYPE html>
<html lang="en">  
    <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/head.php'; ?>
    <body>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/header.php'; ?>
        <div class="container">
            <h4 id="page-title">Lietotāji</h4>
            <div class="option-container">
                <a class="link-button" href="/veikals/admin/src/users/create.php">Izveidot jaunu</a>
                <select class="panel-select">
                    <option selected disabled> * Super Users</option>
                </select>
            </div>
            <div class="sub-container">
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Surname</th>
                        <th>Email</th>
                        <th></th>
                    </tr>
                    <?php
                        $conn = Database::getConnection();

                        $stmt = $conn->prepare("SELECT * FROM user");
                        $stmt->execute();
                        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($users as $user) {
                            echo '<tr>';
                                echo '<td>'.$user['user_id'].'</td>';
                                echo '<td>'.$user['name'].'</td>';
                                echo '<td>'.$user['surname'].'</td>';
                                echo '<td>'.$user['email'].'</td>';
                                ?> <td>
                                    <a href="update.php">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                        </svg>
                                    </a>
                                </td> <?php
                            echo '</tr>';
                        }

                        $conn = Database::closeConnection();
                    ?>
                </table>
            </div>
        </div>
    </body>
</html>