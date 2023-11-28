<?php 
    $redirect = '/veikals/admin/index.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/sessionCheck.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/tempCheck.php';

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/TagLoader.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/FileUpload.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/ImageSelectElement.php';

    $ordersData = $data['form-data'];
?>

<!DOCTYPE html>
<html lang="en">  
    <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/head.php'; ?>
    <body>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/header.php'; ?>

        <div class="main-container">
            <h4><?php echo isset($page['title']) ? $page['title'] : ''; ?></h4>

            <form id="main-form" novalidate method="post">
                <div class="row">
                    <div class="col-sm-4">
                        <?php 
                            $title = 'Numurs';
                            $tagName = 'number';
                            $variableData = $ordersData[$tagName];
                            $placeholder = 'Ievadi numuru';
                            $errorConditions = [
                                FormErrorType::EMPTY->value => 'Numurs nav ievadīts'
                            ];
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
                        <?php TagLoader::loadInputErrorMessage($variableData, $errorConditions); ?>


                        <?php 
                            $title = 'Klients';
                            $tagName = 'client_id';
                            $variableData = $ordersData[$tagName];
                            $errorConditions = [
                                FormErrorType::EMPTY->value => 'Klients nav izvēlēts'
                            ];
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
                        <?php TagLoader::loadInputErrorMessage($variableData, $errorConditions); ?>


                        <?php 
                            $title = 'Datums';
                            $tagName = 'date';
                            $variableData = $ordersData[$tagName];
                            $errorConditions = FormTypeErrorConditions::DATE_DEFAULT;
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
                                        echo $variableData['value'];
                            ?>">
                        <?php TagLoader::loadInputErrorMessage($variableData, $errorConditions); ?>


                        <?php 
                            $title = 'Cena (eiro)';
                            $tagName = 'total_price';
                            $variableData = $ordersData[$tagName];
                            $placeholder = 'Ievadi cenu';
                            $errorConditions = [
                                FormErrorType::EMPTY->value => 'Cena nav ievadīta'
                            ];
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
                        <?php TagLoader::loadInputErrorMessage($variableData, $errorConditions); ?>


                        <?php 
                            $title = 'Statuss';
                            $tagName = 'state_id';
                            $variableData = $ordersData[$tagName];
                            $errorConditions = [
                                FormErrorType::EMPTY->value => 'Statuss nav norādīts'
                            ];
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
                        <?php TagLoader::loadInputErrorMessage($variableData, $errorConditions); ?>
                    </div>
                    <div class="col">
                        <?php 
                            $title = 'Preces';
                            $tagName = 'products';
                            $variableData = $ordersData[$tagName];
                            $errorConditions = [
                                FormErrorType::EMPTY->value => 'Statuss nav norādīts'
                            ];
                        ?>
                        <?php 
                            TagLoader::loadLabel($title, $tagName, $variableData);

                            include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/products/data.php';
                            include 'editableTable/editableTable.php';

                            TagLoader::loadInputErrorMessage($variableData, $errorConditions);
                        ?>
                    </div>
                </div>
                <div class="element-row">
                    <?php 
                        TagLoader::loadButtonRow($page);
                    ?>
                </div>
            </form>
        </div>
    </body>
</html>