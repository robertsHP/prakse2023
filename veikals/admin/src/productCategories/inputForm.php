<?php 
    /*
        !!!!!PADOTIE DATI!!!!!

        $dataArray = [
            'categoryData' => [
                'name' => ...
            ],
            'page' => [
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
        ];
    */
?>

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
                                placeholder="Ievadi nosaukumu" 
                                value="<?php 
                                    if(isset($dataArray['categoryData']['name']))
                                        echo $dataArray['categoryData']['name']
                                ?>">
                            <?php
                                if(isset($dataArray['categoryData']['name']) && empty($dataArray['categoryData']['name']))
                                    outputAlert("Kategorijas vārds ir nepieciešams");
                            ?>
                        </div>
                    </div>
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