<?php 
    $redirect = '/veikals/admin/index.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/sessionCheck.php';
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/Database.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUDFunctions.php';
    require_once 'formData.php';
    
    CRUDFunctions::processCreate('product', $formData);

    //Dati priekš inputForm.php
    $dataArray = [
        'formData' => $formData,
        'page' => [
            'title' => 'Pievienot jaunu preci',
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