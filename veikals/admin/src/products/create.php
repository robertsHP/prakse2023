<?php 
    $redirect = '/veikals/admin/index.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/sessionCheck.php';
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/Database.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUDFunctions.php';

    include 'data.php';

    CRUDFunctions::create(
        $tableName, 
        $formData, 
        function ($tableName, &$formData) {
            if(isset($_FILES['photo_file_loc'])) {
                $success = CRUDFunctions::uploadFile('products', 'photo_file_loc', $formData);
                if($success) {
                    $success = Database::insert($tableName, $formData);
                    if($success) {
                        header('Location: index.php');
                        exit();
                    }
                }
            }
        }
    );

    //Lapas dati priekš inputForm.php
    $page = [
        'title' => 'Pievienot jaunu preci',
        'buttons' => [
            [
                'type' => 'submit',
                'name' => 'back',
                'value' => 'Atpakaļ',
                'class' => 'btn btn-primary execution-button'
            ],
            [
                'type' => 'submit',
                'name' => 'save',
                'value' => 'Saglabāt',
                'class' => 'btn btn-primary execution-button'
            ]
        ]
    ];
    include 'inputForm.php'; 
?>