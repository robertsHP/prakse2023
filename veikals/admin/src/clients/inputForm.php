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

            <form 
                novalidate 
                method="post" 
                action="" 
                enctype="multipart/form-data"
            >
                <div class="row">
                    <div class="col-sm-6">
                        <?php 
                            $title = 'Vārds/Nosaukums';
                            $tagName = 'name';
                            $variableData = $formData[$tagName];
                            $placeholder = 'Ievadi vārdu';
                            $errorConditions = [
                                FormErrorType::EMPTY->value => 'Kategorijas nosaukums ir nepieciešams'
                            ];
                        ?>
                        <?php BasicFormTagLoader::loadLabel($title, $tagName, $variableData); ?>
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
                        <?php BasicFormTagLoader::loadErrorMessage($variableData, $errorConditions); ?>


                        <?php 
                            $title = 'E-pasts';
                            $tagName = 'email';
                            $variableData = $formData[$tagName];
                            $placeholder = 'name@example.com';
                            $errorConditions = FormTypeErrorConditions::EMAIL_DEFAULT;
                        ?>
                        <?php BasicFormTagLoader::loadLabel($title, $tagName, $variableData); ?>
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
                        <?php BasicFormTagLoader::loadErrorMessage($variableData, $errorConditions); ?>


                        <?php 
                            $title = 'Telefona numurs';
                            $tagName = 'phone_number';
                            $variableData = $formData[$tagName];
                            $errorConditions = FormTypeErrorConditions::PHONE_NUMBER_DEFAULT;
                            $placeholder = '+371XXXXXXXX';
                        ?>
                        <?php BasicFormTagLoader::loadLabel($title, $tagName, $variableData); ?>
                        <div class="row">
                            <div class="col-4">
                                <input 
                                    type="text" 
                                    class="form-control"
                                    maxlength="17"
                                    id="<?php echo $tagName; ?>"
                                    name="<?php echo $tagName; ?>"
                                    placeholder="<?php echo $placeholder; ?>"
                                    value="<?php 
                                        if(isset($variableData))
                                            echo $variableData['value'];
                                ?>">
                                <script>
                                    //Ļauj ievadīt tikai + un ciparus
                                    var id = <?php echo json_encode($tagName); ?>;
                                    document.getElementById(id).addEventListener('input', function() {
                                        if(this.value !== 0) {
                                            if(this.value[0] !== '+') {
                                                this.value = '+'+this.value;
                                            }
                                        }
                                        this.value = this.value.replace(/[^+\d]/g, '');
                                    });
                                </script>
                            </div>
                        </div> 
                        <?php BasicFormTagLoader::loadErrorMessage($variableData, $errorConditions); ?>


                        <?php 
                            $title = 'Adrese';
                            $tagName = 'adress';
                            $variableData = $formData[$tagName];
                            $placeholder = 'Ievadi adresi';
                            $errorConditions = [
                                FormErrorType::EMPTY->value => 'Adrese ir nepieciešama'
                            ];
                        ?>
                        <?php BasicFormTagLoader::loadLabel($title, $tagName, $variableData); ?>
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
                        <?php BasicFormTagLoader::loadErrorMessage($variableData, $errorConditions); ?>
                    </div>
                </div>
                <div class="element-row">
                    <?php BasicFormTagLoader::loadButtonRow($page); ?>
                </div>
            </form>
        </div>
    </body>
</html>