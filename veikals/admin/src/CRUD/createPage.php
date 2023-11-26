<?php 
    /*
        $tableName = ...
        $idColumnName = ...
        $data = []
        $redirectPath = ...
        $inputFormPath = ...
        $pageTitle = ...
    */

    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/CRUDFunctions.php';

    CRUDFunctions::create(
        $data['table-name'], 
        $data['form-data']
    );

    //Lapas dati priekš inputForm.php
    $page = [
        'title' => $pageTitle,
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

    $inputFormPath = '/veikals/admin/src/'.$data['table-name'].'/inputForm.php';

    include $_SERVER['DOCUMENT_ROOT'].$inputFormPath;
?>