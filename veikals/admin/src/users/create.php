<?php 
    $redirect = '/veikals/admin/index.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/sessionCheck.php';
    
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

                header('Location: index.php');
                exit();
            }
        } else if (isset($_POST['back'])) {
            header('Location: index.php');
            exit();
        }
    }
?>

<?php 
    $dataArray = [
        'page' => [
            'title' => 'Izveidot jaunu lietotāju',
            'buttons' => [
                [
                    'type' => 'submit',
                    'name' => 'back',
                    'value' => 'Atpakaļ',
                    'class' => 'btn btn-outline-primary execution-button'
                ],
                [
                    'type' => 'submit',
                    'name' => 'save',
                    'value' => 'Saglabāt',
                    'class' => 'btn btn-primary execution-button'
                ]
            ]
        ]
    ];
    include 'inputForm.php'; 
?>