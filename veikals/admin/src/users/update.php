<?php 
    $redirect = '/veikals/admin/index.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/sessionCheck.php';
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/Database.php';
?>

<?php
    //pārbauda vai ID ir padots
    if (!isset($_GET['id'])) {
        header('Location: index.php');
        exit();
    }
    $id = $_GET['id'];

    $conn = Database::openConnection();

    //pārbauda vai šāds lietotājs ir datubāzē
    $stmt = $conn->prepare("SELECT * FROM user WHERE user_id=:id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    Database::closeConnection($conn);
    
    if(empty($result)) {
        header('Location: index.php');
        exit();
    }

    //Apstrādā formā ievadīto informāciju
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['save'])) {
            $name = $_POST['name'];
            $surname = $_POST['surname'];
            $email = $_POST['email'];

            ///Pārbauda vai viss ir ievadīts
            if (!empty($name) && !empty($surname) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $conn = Database::openConnection();

                $stmt = $conn->prepare("UPDATE user SET name = :name, surname = :surname, email = :email WHERE user_id = :id");
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':surname', $surname, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();

                Database::closeConnection($conn);
                header('Location: index.php');
                exit();
            }
        } else if (isset($_POST['delete'])) {
            header('Location: delete.php?id='.$id);
            exit();
        } else if (isset($_POST['back'])) {
            header('Location: index.php');
            exit();
        }
    } else {
        $name = $result[0]["name"];
        $surname = $result[0]["surname"];
        $email = $result[0]["email"];
    }
?>

<?php 
    //dati priekš inputForm.php
    $dataArray = [
        'userData' => [
            'name' => $name,
            'surname' => $surname,
            'email' => $email,
        ],
        'page' => [
            'title' => 'Rediģēt lietotāja informāciju',
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
                ],
                [
                    'type' => 'submit',
                    'name' => 'delete',
                    'value' => 'Dzēst',
                    'class' => 'btn btn-danger execution-button'
                ]
            ]
        ]
    ];
    include 'inputForm.php'; 
?>