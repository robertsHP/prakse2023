<?php 
    $redirectPath = '/veikals/admin/index.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/sessionCheck.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/tempCheck.php';

    include 'data.php';

    $pageTitle = 'Preces informācija';

    if (isset($_GET['id'])) {
        $data['id'] = $_GET['id'];
    }

    function displayData ($idColumnName, $data, $row) {
        $keys = array_keys($data);
        ?>
            <table class="table table-hover">
                <tr>
                    <th>ID: </th>
                    <th><?php echo $row[$idColumnName] ?></th>
                </tr>
                <tr>
                    <th>Nosaukums: </th>
                    <th><?php echo $row[$keys[0]] ?></th>
                </tr>
                <tr>
                    <th>Apraksts: </th>
                    <th><?php echo $row[$keys[1]] ?></th>
                </tr>
                <tr>
                    <th>Bilde: </th>
                    <th>
                        <img 
                            src="<?php 
                                if(isset($row[$keys[2]]))
                                    echo $row[$keys[2]];
                            ?>" 
                            name="photo_file_loc"
                            id="photo_file_loc"
                            class="img-thumbnail img-product-photo" 
                            alt="">
                    </th>
                </tr>
                <tr>
                    <th>Cena: </th>
                    <th><?php echo $row[$keys[3]].' eiro' ?></th>
                </tr>
                <tr>
                    <th>Pieejamais daudzums: </th>
                    <th><?php echo $row[$keys[4]] ?></th>
                </tr>
                <tr>
                    <th>Kategorija: </th>
                    <th>
                        <?php 
                            $catRow = Database::getRowWithID(
                                'product_categories', 
                                $keys[5], 
                                $row[$keys[5]]);
                            echo $catRow['name'];
                        ?>
                    </th>
                </tr>
            </table>
        <?php
    }

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/readPage.php';
?>