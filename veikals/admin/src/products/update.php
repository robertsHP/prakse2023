<?php 
    $redirect = '/veikals/admin/index.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/sessionCheck.php';
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/Database.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/FileManager.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUDFunctions.php';
    
    include 'data.php';

    CRUDFunctions::update(
        $tableName, 
        $idColumnName, 
        $formData
    );

    //Lapas dati priekš inputForm.php
    $page = [
        'title' => 'Rediģēt preces informāciju',
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
            ],
            [
                'type' => 'submit',
                'name' => 'delete',
                'value' => 'Dzēst',
                'class' => 'btn btn-danger execution-button'
            ]
        ]
    ];
    include 'inputForm.php'; 
?>