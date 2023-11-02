<?php 
    $redirect = '/veikals/admin/index.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/sessionCheck.php';
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/Database.php';
?>

<?php
    $name = null;

    //Apstrādā formā ievadīto informāciju
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['save'])) {
            $name = $_POST['name'];

            ///Pārbauda vai viss ir ievadīts
            if (!empty($name)) {
                $conn = Database::openConnection();

                $stmt = $conn->prepare("INSERT INTO product_category (name) VALUES (:name)");
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
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
    //Dati priekš inputForm.php
    $dataArray = [
        'categoryData' => [
            'name' => $name
        ],
        'page' => [
            'title' => 'Izveidot jaunu preces kategoriju',
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