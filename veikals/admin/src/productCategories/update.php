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
    $row = Database::getRowFromTable('product_category', 'category_id', $id, PDO::PARAM_INT);
    
    if(empty($row)) {
        header('Location: index.php');
        exit();
    }

    //Apstrādā formā ievadīto informāciju
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['save'])) {
            $name = $_POST['name'];

            ///Pārbauda vai viss ir ievadīts
            if (!empty($name)) {
                $conn = Database::openConnection();

                $stmt = $conn->prepare("UPDATE product_category SET name = :name WHERE category_id = :id");
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
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
        $name = $row["name"];
    }
?>

<?php 
    //dati priekš inputForm.php
    $dataArray = [
        'categoryData' => [
            'name' => $name
        ],
        'page' => [
            'title' => 'Rediģēt kategorijas informāciju',
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