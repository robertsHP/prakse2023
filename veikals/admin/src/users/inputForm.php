<?php 
    $redirect = '/veikals/admin/index.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/sessionCheck.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/tempCheck.php';

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/TagLoader.php';
?>

<!DOCTYPE html>
<html lang="en">  
    <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/head.php'; ?>
    <body>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/header.php'; ?>

        <div class="main-container">
            <h4> <?php echo isset($pageTitle) ? $pageTitle : ''; ?></h4>

            <form class="input-form" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-6">
                        <?php 
                            $title = 'Vārds';
                            $tagName = 'name';
                            $variableData = $data['form-data'][$tagName];
                            $placeholder = 'Ievadi vārdu';
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
                    </div>
                    <div class="col-sm-6">
                        <?php 
                            $title = 'Uzvārds';
                            $tagName = 'surname';
                            $variableData = $data['form-data'][$tagName];
                            $placeholder = 'Ievadi uzvārdu';
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
                    </div>
                </div>
                <div class="form-group">
                    <?php 
                        $title = 'E-pasts';
                        $tagName = 'email';
                        $variableData = $data['form-data'][$tagName];
                        $placeholder = 'name@example.com';
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