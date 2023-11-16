<?php 
    $redirect = '/veikals/admin/index.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/sessionCheck.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/tempCheck.php';

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/BasicFormTagLoader.php';
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
                        
                            BasicFormTagLoader::loadLabel($title, $tagName, $variableData);
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
                            BasicFormTagLoader::loadErrorMessage($variableData, $errorConditions);
                        ?>

                        <?php 
                            $title = 'Apraksts';
                            $tagName = 'description';
                            $variableData = $formData[$tagName];
                            $fieldRequired = true;
                            $placeholder = '...';
                            $errorConditions = [
                                FormErrorType::EMPTY->value => 'Apraksts nav ievadīts'
                            ];

                            BasicFormTagLoader::loadLabel($title, $tagName, $variableData);
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
                            BasicFormTagLoader::loadErrorMessage($variableData, $errorConditions);
                        ?>

                        <?php 
                            $title = 'Bilde';
                            $tagName = 'photo_file_loc';
                            $variableData = $formData[$tagName];
                            $errorConditions = [
                                FormErrorType::EMPTY->value                     => 'Fails nav pievienots',
                                FormErrorType::FILE_ALREADY_EXISTS->value       => 'Fails jau eksistē',
                                FormErrorType::FILE_TOO_LARGE->value            => 'Fails ir pārāk liels',
                                FormErrorType::FILE_FORMAT_INCORRECT->value     => 'Faila formāts nav pareizs',
                                FormErrorType::FILE_IS_NOT_AN_IMAGE->value      => 'Fails nav bilde',
                                FormErrorType::FILE_UPLOAD_UNSUCCESSFUL->value  => 'Faila augšupielāde nebija veiksmīga'
                            ];
                            $allowedFileTypes = implode(', ', $variableData['allowed_file_formats']);

                            BasicFormTagLoader::loadLabel($title, $tagName, $variableData);

                            include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/loadImageSelect.php';
                            
                            BasicFormTagLoader::loadErrorMessage($variableData, $errorConditions);
                        ?>
                        
                        <br>

                        <?php 
                            $title = 'Cena (eiro)';
                            $tagName = 'price';
                            $variableData = $formData[$tagName];
                            $placeholder = 'Ievadi cenu';
                            $errorConditions = [
                                FormErrorType::EMPTY->value => 'Cena nav ievadīta'
                            ];

                            BasicFormTagLoader::loadLabel($title, $tagName, $variableData);
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
                            BasicFormTagLoader::loadErrorMessage($variableData, $errorConditions);
                        ?>

                        <?php 
                            $title = 'Pieejamais daudzums';
                            $tagName = 'available_amount';
                            $variableData = $formData[$tagName];
                            $placeholder = 'Ievadi daudzumu';
                            $errorConditions = [
                                FormErrorType::EMPTY->value => 'Daudzums nav ievadīts'
                            ];

                            BasicFormTagLoader::loadLabel($title, $tagName, $variableData);
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
                            BasicFormTagLoader::loadErrorMessage($variableData, $errorConditions);
                        ?>

                        <?php 
                            $title = 'Kategorija';
                            $tagName = 'category_id';
                            $variableData = $formData[$tagName];
                            $placeholder = 'Izvēlies kategoriju';
                            $errorConditions = [
                                FormErrorType::EMPTY->value => 'Kategorija nav izvēlēta'
                            ];

                            BasicFormTagLoader::loadLabel($title, $tagName, $variableData);
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
                        <?php 
                            BasicFormTagLoader::loadErrorMessage($variableData, $errorConditions);
                        ?>
                    </div>
                </div>
                <div class="element-row">
                    <?php 
                        BasicFormTagLoader::loadButtonRow($page);
                    ?>
                </div>
            </form>
        </div>
    </body>
</html>