<?php 
    $redirect = '/veikals/admin/index.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/sessionCheck.php';
?>

<?php
    function outputButton ($type, $name, $value, $class) {
        echo '<input 
            type="'.$type.'" 
            name="'.$name.'" 
            value="'.$value.'" 
            class="'.$class.'">
        ';
    }
    function outputAlert ($strMsg) {
        echo '
            <div class="alert alert-danger">
                '.$strMsg.'
            </div>
        ';
    }
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
                        <div class="form-group">
                            <label for="name">
                                Vārds<span class="required-star">*</span>
                            </label>
                            <input 
                                type="text" 
                                class="form-control" 
                                name="name" 
                                id="name" 
                                placeholder="Ievadi vārdu" 
                                value="<?php 
                                    if(isset($dataArray['userData']['name']))
                                        echo $dataArray['userData']['name']
                            ?>">
                            <?php
                                if(isset($dataArray['userData']['name']) && empty($dataArray['userData']['name']))
                                    outputAlert("Vārds ir nepieciešams");
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="surname">
                                Uzvārds<span class="required-star">*</span>
                            </label>
                            <input 
                                type="text" 
                                class="form-control" 
                                name="surname" 
                                id="surname" 
                                placeholder="Ievadi uzvārdu" 
                                value="<?php 
                                    if(isset($dataArray['userData']['surname']))
                                        echo $dataArray['userData']['surname']; 
                            ?>">
                            <?php
                                if(isset($dataArray['userData']['surname']) && empty($dataArray['userData']['surname']))
                                    outputAlert("Uzvārds ir nepieciešams");
                            ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">
                        E-pasts<span class="required-star">*</span>
                    </label>
                    <input 
                        type="email" 
                        class="form-control" 
                        name="email" 
                        id="email"
                        placeholder="name@example.com" 
                        value="<?php 
                            if(isset($dataArray['userData']['email']))
                                echo $dataArray['userData']['email']; 
                    ?>">
                    <?php
                        if(isset($dataArray['page']['email']) && empty($dataArray['page']['email']))
                            outputAlert("E-pasts ir nepieciešams");
                    ?>
                </div>
                <?php 
                    if(isset($dataArray['page']['buttons'])) {
                        foreach ($dataArray['page']['buttons'] as $buttonInfo) {
                            outputButton(
                                $buttonInfo['type'],
                                $buttonInfo['name'],
                                $buttonInfo['value'],
                                $buttonInfo['class']
                            );
                        }
                    }
                ?>
            </form>
        </div>
    </body>
</html>