<?php 
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/TagLoader.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/Database.php';
?>

<!DOCTYPE html>
<html lang="en">  
    <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/head.php'; ?>
    <body>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/header.php'; ?>

        <div class="main-container">
            <h4><?php echo isset($pageTitle) ? $pageTitle : ''; ?></h4>

            <form class="input-form" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-4">
                        <?php 
                            $title = 'Numurs';
                            $tagName = 'number';
                            $variableData = $data['form-data'][$tagName];
                            $placeholder = 'Ievadi numuru';
                        ?>
                        <?php TagLoader::loadLabel($title, $tagName, $variableData); ?>
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
                            $data['error-tags'][$tagName] = [
                                'id' => $tagName.'-alert',
                                'error-conditions' => [
                                    FormErrorType::EMPTY->value => 'Numurs nav ievadīts'
                                ]
                            ];
                            TagLoader::loadInputErrorMessage($tagName, $variableData);
                        ?>


                        <?php 
                            $title = 'Klients';
                            $tagName = 'client_id';
                            $variableData = $data['form-data'][$tagName];
                        ?>
                        <?php TagLoader::loadLabel($title, $tagName, $variableData); ?>
                            <select 
                                class="form-control"
                                name="<?php echo $tagName; ?>"
                                id="<?php echo $tagName; ?>"
                                value="<?php 
                                    if(isset($variableData))
                                        echo $variableData['value'];
                            ?>">
                                <?php
                                    $rows = Database::getAllRowsFrom('clients');
                                    foreach ($rows as $row) {
                                        $selected = $row[$tagName] == $variableData['value'] ? ' selected' : '';
                                        echo '<option 
                                            value="'.$row[$tagName].'"
                                            '.$selected.'
                                        >'.$row['name'].'</option>';
                                    }
                                ?>
                            </select>
                        <?php 
                            $data['error-tags'][$tagName] = [
                                'id' => $tagName.'-alert',
                                'error-conditions' => [
                                    FormErrorType::EMPTY->value => 'Klients nav izvēlēts'
                                ]
                            ];
                            TagLoader::loadInputErrorMessage($tagName, $variableData);
                        ?>


                        <?php 
                            $title = 'Datums';
                            $tagName = 'date';
                            $variableData = $data['form-data'][$tagName];
                        ?>
                        <?php TagLoader::loadLabel($title, $tagName, $variableData); ?>
                            <input 
                                type="date"  
                                class="form-control" 
                                name="<?php echo $tagName; ?>"
                                id="<?php echo $tagName; ?>"
                                step=".01"
                                value="<?php 
                                    if(isset($variableData))
                                        echo date('Y-m-d', strtotime($variableData['value']));
                            ?>">
                        <?php 
                            $data['error-tags'][$tagName] = [
                                'id' => $tagName.'-alert',
                                'error-conditions' => FormTypeErrorConditions::DATE_DEFAULT
                            ];
                            TagLoader::loadInputErrorMessage($tagName, $variableData);
                        ?>


                        <?php 
                            $title = 'Cena (eiro)';
                            $tagName = 'total_price';
                            $variableData = $data['form-data'][$tagName];
                            $placeholder = 'Ievadi cenu';
                        ?>
                        <?php TagLoader::loadLabel($title, $tagName, $variableData); ?>
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
                            $data['error-tags'][$tagName] = [
                                'id' => $tagName.'-alert',
                                'error-conditions' => [
                                    FormErrorType::EMPTY->value => 'Cena nav ievadīta'
                                ]
                            ];
                            TagLoader::loadInputErrorMessage($tagName, $variableData);
                        ?>


                        <?php 
                            $title = 'Statuss';
                            $tagName = 'state_id';
                            $variableData = $data['form-data'][$tagName];
                        ?>
                        <?php TagLoader::loadLabel($title, $tagName, $variableData); ?>
                            <select 
                                class="form-control"
                                name="<?php echo $tagName; ?>"
                                id="<?php echo $tagName; ?>"
                                value="<?php 
                                    if(isset($variableData))
                                        echo $variableData['value'];
                            ?>">
                                <?php
                                    $rows = Database::getAllRowsFrom('order_states');
                                    foreach ($rows as $row) {
                                        $selected = $row[$tagName] == $variableData['value'] ? ' selected' : '';
                                        echo '<option 
                                            value="'.$row[$tagName].'"
                                            '.$selected.'
                                        >'.$row['name'].'</option>';
                                    }
                                ?>
                            </select>
                        <?php 
                            $data['error-tags'][$tagName] = [
                                'id' => $tagName.'-alert',
                                'error-conditions' => [
                                    FormErrorType::EMPTY->value => 'Statuss nav norādīts'
                                ]
                            ];
                            TagLoader::loadInputErrorMessage($tagName, $variableData);
                        ?>
                    </div>
                    <div class="col">
                        <?php 
                            $title = 'Preces';
                            $tagName = 'products';
                            $variableData = $data['form-data'][$tagName];
                        ?>
                        <?php 
                            TagLoader::loadLabel($title, $tagName, $variableData);

                            // include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/products/data.php';
                            // $productsData = $data;
                            // include 'editableTable/editableTable.php';

                            $data['error-tags'][$tagName] = [
                                'id' => $tagName.'-alert',
                                'error-conditions' => [
                                    FormErrorType::EMPTY->value => 'Statuss nav norādīts'
                                ]
                            ];
                            TagLoader::loadInputErrorMessage($tagName, $variableData);
                        ?>
                    </div>
                </div>
            </form>
            <?php
                include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/hideErrorTags.php';
            ?>
            <div class="element-row">
                <?php
                    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/backButton.php';
                    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/saveButton.php';
                    if(isset($data['id']))
                        include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/deleteButton.php';
                ?>
            </div>
        </div>
    </body>
</html>