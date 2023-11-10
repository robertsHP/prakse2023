<?php 
    /*
        !!!!!PADOTIE DATI!!!!!

        $formData = []
        $page => [
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
            <h4><?php echo isset($page['title']) ? $page['title'] : ''; ?></h4>

            <form method="post" action="" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-6">
                        <?php 
                            $title = 'Nosaukums';
                            $tagName = 'name';
                            $variableData = $formData[$tagName];
                            $placeholder = 'Ievadi nosaukumu';
                            $errorConditions = [
                                FormErrorType::EMPTY->value => 'Nosaukums nav ievadīts'
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

                        <?php 
                            $title = 'Apraksts';
                            $tagName = 'description';
                            $variableData = $formData[$tagName];
                            $fieldRequired = true;
                            $placeholder = '...';
                            $errorConditions = [
                                FormErrorType::EMPTY->value => 'Apraksts nav ievadīts'
                            ];

                            FormElement::loadLabel($title, $tagName, $variableData);
                            FormElement::loadErrorMessage($variableData, $errorConditions);
                        ?>
                            <textarea 
                                class="form-control"
                                name="<?php echo $tagName; ?>"
                                id="<?php echo $tagName; ?>"
                                rows="4" 
                                cols="50" 
                                placeholder="<?php echo $placeholder; ?>"
                            ><?php 
                                if(isset($variableData))
                                    echo $variableData['value'];
                            ?></textarea>

                        <?php 
                            $title = 'Bilde';
                            $tagName = 'photo_file_loc';
                            $variableData = $formData[$tagName];
                            $errorConditions = getFileErrorTypes();

                            $allowedFileTypes = implode(', ', $formData[$tagName]['allowed_file_formats']);
                        ?>
                            <div class="mb-3">
                                <?php
                                    FormElement::loadLabel($title, $tagName, $variableData);
                                    FormElement::loadErrorMessage($variableData, $errorConditions);
                                ?>
                                <input 
                                    type="file"  
                                    class="form-control-file" 
                                    name="<?php echo $tagName; ?>"
                                    id="<?php echo $tagName; ?>"
                                    accept="<?php echo $allowedFileTypes; ?>"
                                    value="<?php 
                                        if(isset($variableData))
                                            echo $variableData['value'];
                                    ?>">
                            </div>
                            <img 
                                src="<?php 
                                    if(isset($variableData))
                                        echo $variableData['value'];
                                ?>" 
                                name = <?php echo $tagName.'_thumbnail'; ?>
                                id =<?php echo $tagName.'_thumbnail'; ?>
                                class="img-thumbnail" 
                                alt="">
                        <br>

                        <?php 
                            $title = 'Cena (eiro)';
                            $tagName = 'price';
                            $variableData = $formData[$tagName];
                            $placeholder = 'Ievadi cenu';
                            $errorConditions = [
                                FormErrorType::EMPTY->value => 'Cena nav ievadīta'
                            ];

                            FormElement::loadLabel($title, $tagName, $variableData);
                            FormElement::loadErrorMessage($variableData, $errorConditions);
                        ?>
                            <input 
                                type="number"  
                                class="form-control" 
                                name="<?php echo $tagName; ?>"
                                id="<?php echo $tagName; ?>"
                                placeholder="<?php echo $placeholder; ?>"
                                step=".01"
                                value="<?php 
                                    if(isset($variableData))
                                        echo $variableData['value'];
                            ?>">

                            
                        <?php 
                            $title = 'Pieejamais daudzums';
                            $tagName = 'available_amount';
                            $variableData = $formData[$tagName];
                            $placeholder = 'Ievadi cenu';
                            $errorConditions = [
                                FormErrorType::EMPTY->value => 'Daudzums nav ievadīts'
                            ];

                            FormElement::loadLabel($title, $tagName, $variableData);
                            FormElement::loadErrorMessage($variableData, $errorConditions);
                        ?>
                            <input 
                                type="number"  
                                class="form-control" 
                                name="<?php echo $tagName; ?>"
                                id="<?php echo $tagName; ?>"
                                placeholder="<?php echo $placeholder; ?>"
                                value="<?php 
                                    if(isset($variableData))
                                        echo $variableData['value'];
                            ?>">

                        <?php 
                            $title = 'Kategorija';
                            $tagName = 'category_id';
                            $variableData = $formData[$tagName];
                            $placeholder = 'Izvēlies kategoriju';
                            $errorConditions = [
                                FormErrorType::EMPTY->value => 'Kategorija nav izvēlēta'
                            ];

                            FormElement::loadLabel($title, $tagName, $variableData);
                            FormElement::loadErrorMessage($variableData, $errorConditions);

                        ?>
                            <select 
                                class="form-control"
                                name="<?php echo $tagName; ?>"
                                id="<?php echo $tagName; ?>"
                                value="<?php 
                                    if(isset($variableData))
                                        echo $variableData['value'];
                            ?>">
                                <?php
                                    $rows = Database::getAllRowsFrom('product_category');
                                    foreach ($rows as $row) {
                                        $selected = $row['category_id'] == $variableData['value'] ? ' selected' : '';
                                        echo '<option 
                                            value="'.$row['category_id'].'"
                                            '.$selected.'
                                        >'.$row['name'].'</option>';
                                    }
                                ?>
                            </select>
                    </div>
                </div>
                <?php 
                    FormElement::loadButtonRow($page);
                ?>
            </form>
        </div>
    </body>
</html>