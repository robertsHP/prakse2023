<?php 
    /*
        !!!!!PADOTIE DATI!!!!!

        $dataArray = [
            'formData' => [
                'name' => ...
            ],
            'page' => [
                'title' => ...,
                'buttons' => [
                    [
                        'type' => ...,
                        'name' => ...,
                        'value' => ...,
                        'class' => ...
                    ],
                    ....
                ]
            ]
        ];
    */

    $redirect = '/veikals/admin/index.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/sessionCheck.php';

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/FormElement.php';
?>

<!DOCTYPE html>
<html lang="en">  
    <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/head.php'; ?>
    <body>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/header.php'; ?>

        <div class="main-container">
            <h4>
                <?php 
                    echo isset($dataArray['page']['title']) ? $dataArray['page']['title'] : ''; 
                ?>
            </h4>

            <form method="post" action="">
                <div class="row">
                    <div class="col-sm-6">
                        <?php
                            FormElement::input([
                                'name' => 'name',
                                'title' => 'Nosaukums',
                                'required' => true,
                                'type' => 'text',
                                'placeholder' => 'Ievadi nosaukumu',
                                'variable' => $dataArray['formData']['name'],
                                'errorCheck' => [
                                    ['Kategorijas nosaukums ir nepieciešams', empty($dataArray['formData']['name']['value'])]
                                ]
                            ]);
                        ?>
                    </div>
                </div>
                <?php 
                    FormElement::buttonRow($dataArray['page']);
                ?>
            </form>
        </div>
    </body>
</html>