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
                            $title = 'Vārds';
                            $tagName = 'name';
                            $variableData = $formData[$tagName];
                            $placeholder = 'Ievadi vārdu';
                            $errorConditions = [
                                FormErrorType::EMPTY->value => 'Vārds ir nepieciešams'
                            ];
                        
                            FormElement::loadLabel($title, $tagName, $variableData);
                            FormElement::loadErrorMessage($variableData, $errorConditions);
                        ?>
                            <input 
                                type="text"  
                                class="form-control" 
                                name="<?php echo $tagName; ?>"
                                id="<?php echo $tagName; ?>"
                                placeholder="<?php echo $placeholder; ?>"
                                value="<?php 
                                    if(isset($variableData))
                                        echo $variableData['value'];
                            ?>">
                    </div>
                    <div class="col-sm-6">
                        <?php 
                            $title = 'Uzvārds';
                            $tagName = 'surname';
                            $variableData = $formData[$tagName];
                            $placeholder = 'Ievadi uzvārdu';
                            $errorConditions = [
                                FormErrorType::EMPTY->value => 'Uzvārds ir nepieciešams'
                            ];
                        
                            FormElement::loadLabel($title, $tagName, $variableData);
                            FormElement::loadErrorMessage($variableData, $errorConditions);
                        ?>
                            <input 
                                type="text"  
                                class="form-control" 
                                name="<?php echo $tagName; ?>"
                                id="<?php echo $tagName; ?>"
                                placeholder="<?php echo $placeholder; ?>"
                                value="<?php 
                                    if(isset($variableData))
                                        echo $variableData['value'];
                            ?>">
                    </div>
                </div>
                <div class="form-group">
                    <?php 
                        $title = 'E-pasts';
                        $tagName = 'surname';
                        $variableData = $formData[$tagName];
                        $placeholder = 'name@example.com';
                        $errorConditions = [
                            FormErrorType::EMPTY->value => 'E-pasts ir nepieciešams',
                            FormErrorType::INVALID->value => 'E-pasts nav pareizi ievadīts'
                        ];
                    
                        FormElement::loadLabel($title, $tagName, $variableData);
                        FormElement::loadErrorMessage($variableData, $errorConditions);
                    ?>
                        <input 
                            type="text"  
                            class="form-control" 
                            name="<?php echo $tagName; ?>"
                            id="<?php echo $tagName; ?>"
                            placeholder="<?php echo $placeholder; ?>"
                            value="<?php 
                                if(isset($variableData))
                                    echo $variableData['value'];
                        ?>">
                </div>
                <?php 
                    FormElement::loadButtonRow($dataArray['page']);
                ?>
            </form>
        </div>
    </body>
</html>