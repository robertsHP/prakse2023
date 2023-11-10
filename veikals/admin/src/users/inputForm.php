<?php 
    /*
        !!!!!PADOTIE DATI!!!!!

        $dataArray = [
            'userData' => [
                'name' => ...,
                'surname' => ...,
                'email' => ...,
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
                                'title' => 'Vārds',
                                'required' => true,
                                'type' => 'text',
                                'placeholder' => 'Ievadi vārdu',
                                'variable' => $dataArray['formData']['name'],
                                'errorCheck' => [
                                    ['Vārds ir nepieciešams', empty($dataArray['formData']['name']['value'])]
                                ]
                            ]);
                        ?>
                    </div>
                    <div class="col-sm-6">
                        <?php
                            FormElement::input([
                                'name' => 'surname',
                                'title' => 'Uzvārds',
                                'required' => true,
                                'type' => 'text',
                                'placeholder' => 'Ievadi uzvārdu',
                                'variable' => $dataArray['formData']['surname'],
                                'errorCheck' => [
                                    ['Uzvārds ir nepieciešams', empty($dataArray['formData']['surname']['value'])]
                                ]
                            ]);
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php
                        FormElement::input([
                            'name' => 'surname',
                            'title' => 'E-pasts',
                            'required' => true,
                            'type' => 'email',
                            'placeholder' => 'name@example.com',
                            'variable' => $dataArray['formData']['email'],
                            'errorCheck' => [
                                ['E-pasts ir nepieciešams', empty($dataArray['formData']['email']['value'])],
                                ['E-pasts nav pareizi ievadīts', 
                                    !filter_var($dataArray['formData']['email']['value'], FILTER_VALIDATE_EMAIL)]
                            ]
                        ]);
                    ?>
                </div>
                <?php 
                    FormElement::buttonRow($dataArray['page']);
                ?>
            </form>
        </div>
    </body>
</html>