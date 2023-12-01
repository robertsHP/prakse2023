<?php 
    $redirect = '/veikals/admin/index.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/sessionCheck.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/tempCheck.php';

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/TagLoader.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/FileUpload.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/Database.php';

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/ImageSelectElement.php';
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
                    <div class="col-sm-6">
                        <?php 
                            $title = 'Nosaukums';
                            $tagName = 'name';
                            $variableData = $data['form-data'][$tagName];
                            $placeholder = 'Ievadi nosaukumu';
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
                        <?php 
                            TagLoader::loadInputErrorMessage($tagName, $variableData);
                        ?>

                        
                        <?php 
                            $title = 'Apraksts';
                            $tagName = 'description';
                            $variableData = $data['form-data'][$tagName];
                            $fieldRequired = true;
                            $placeholder = '...';
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
                        <?php 
                            TagLoader::loadInputErrorMessage($tagName, $variableData);
                        ?>


                        <?php 
                            $title = 'Bilde';
                            $tagName = 'photo_file_loc';
                            $variableData = $data['form-data'][$tagName];
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
                        <?php 
                            TagLoader::loadInputErrorMessage($tagName, $variableData);
                        ?>
                        
                        <br>

                        <?php 
                            $title = 'Cena (eiro)';
                            $tagName = 'price';
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
                            TagLoader::loadInputErrorMessage($tagName, $variableData);
                        ?>

                        <?php 
                            $title = 'Pieejamais daudzums';
                            $tagName = 'available_amount';
                            $variableData = $data['form-data'][$tagName];
                            $placeholder = 'Ievadi daudzumu';
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
                            TagLoader::loadInputErrorMessage($tagName, $variableData);
                        ?>

                        
                        <?php 
                            $title = 'Kategorija';
                            $tagName = 'category_id';
                            $variableData = $data['form-data'][$tagName];
                            $placeholder = 'Izvēlies kategoriju';
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
                        <?php 
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
                    if(isset($data['id']))
                        include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/deleteButton.php';
                    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/saveButton.php';
                ?>
            </div>
        </div>
    </body>
</html>