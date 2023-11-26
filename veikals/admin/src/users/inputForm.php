<?php 
    $redirect = '/veikals/admin/index.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/sessionCheck.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/tempCheck.php';

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/TagLoader.php';

    $usersData = $data['form-data'];
?>

<!DOCTYPE html>
<html lang="en">  
    <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/head.php'; ?>
    <body>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/header.php'; ?>

        <div class="main-container">
            <h4>
                <?php 
                    echo isset($page['title']) ? $page['title'] : ''; 
                ?>
            </h4>

            <form novalidate method="post" action="" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-6">
                        <?php 
                            $title = 'Vārds';
                            $tagName = 'name';
                            $variableData = $usersData[$tagName];
                            $placeholder = 'Ievadi vārdu';
                            $errorConditions = [
                                FormErrorType::EMPTY->value => 'Vārds ir nepieciešams'
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
                    </div>
                    <div class="col-sm-6">
                        <?php 
                            $title = 'Uzvārds';
                            $tagName = 'surname';
                            $variableData = $usersData[$tagName];
                            $placeholder = 'Ievadi uzvārdu';
                            $errorConditions = [
                                FormErrorType::EMPTY->value => 'Uzvārds ir nepieciešams'
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
                    </div>
                </div>
                <div class="form-group">
                    <?php 
                        $title = 'E-pasts';
                        $tagName = 'email';
                        $variableData = $usersData[$tagName];
                        $placeholder = 'name@example.com';
                        $errorConditions = FormTypeErrorConditions::EMAIL_DEFAULT;
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
                </div>
                <div class="element-row">
                    <?php TagLoader::loadButtonRow($page); ?>
                </div>
            </form>
        </div>
    </body>
</html>