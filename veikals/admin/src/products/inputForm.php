<?php 
    $redirect = '/veikals/admin/index.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/sessionCheck.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/tempCheck.php';

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/TagLoader.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/FileUpload.php';

    include $_SERVER['DOCUMENT_ROOT'].'/veikals/global/ImageSelectElement.php';

    $productsData = $data['form-data'];
?>

<!DOCTYPE html>
<html lang="en">  
    <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/head.php'; ?>
    <body>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/header.php'; ?>

        <div class="main-container">
            <h4><?php echo isset($page['title']) ? $page['title'] : ''; ?></h4>

            <form novalidate method="post" action="" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-6">
                        <?php 
                            $title = 'Nosaukums';
                            $tagName = 'name';
                            $variableData = $productsData[$tagName];
                            $placeholder = 'Ievadi nosaukumu';
                            $errorConditions = [
                                FormErrorType::EMPTY->value => 'Nosaukums nav ievadīts'
                            ];
                        ?>
                        <?php TagLoader::loadLabel($title, $tagName, $variableData); ?>
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
                        <?php TagLoader::loadInputErrorMessage($variableData, $errorConditions); ?>

                        
                        <?php 
                            $title = 'Apraksts';
                            $tagName = 'description';
                            $variableData = $productsData[$tagName];
                            $fieldRequired = true;
                            $placeholder = '...';
                            $errorConditions = [
                                FormErrorType::EMPTY->value => 'Apraksts nav ievadīts'
                            ];
                        ?>
                        <?php TagLoader::loadLabel($title, $tagName, $variableData); ?>
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
                        <?php TagLoader::loadInputErrorMessage($variableData, $errorConditions); ?>


                        <?php 
                            $title = 'Bilde';
                            $tagName = 'photo_file_loc';
                            $variableData = $productsData[$tagName];
                            $errorConditions =  FormTypeErrorConditions::FILE_DEFAULT;
                        ?>  
                        <?php TagLoader::loadLabel($title, $tagName, $variableData); ?>
                            <div class="mb-3"> 
                                <?php
                                    ImageSelectElement::load(
                                        $tagName,
                                        $variableData['value'],
                                        $variableData['allowed_file_formats']
                                    );
                                ?>
                            </div>
                        <?php TagLoader::loadInputErrorMessage($variableData, $errorConditions); ?>
                        
                        <br>

                        <?php 
                            $title = 'Cena (eiro)';
                            $tagName = 'price';
                            $variableData = $productsData[$tagName];
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
                            $title = 'Pieejamais daudzums';
                            $tagName = 'available_amount';
                            $variableData = $productsData[$tagName];
                            $placeholder = 'Ievadi daudzumu';
                            $errorConditions = [
                                FormErrorType::EMPTY->value => 'Daudzums nav ievadīts'
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
                        <?php  TagLoader::loadInputErrorMessage($variableData, $errorConditions); ?>

                        
                        <?php 
                            $title = 'Kategorija';
                            $tagName = 'category_id';
                            $variableData = $productsData[$tagName];
                            $placeholder = 'Izvēlies kategoriju';
                            $errorConditions = [
                                FormErrorType::EMPTY->value => 'Kategorija nav izvēlēta'
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
                                    $rows = Database::getAllRowsFrom('product_categories');
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