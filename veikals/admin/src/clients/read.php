<?php 
    $redirectPath = '/veikals/admin/index.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/sessionCheck.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/tempCheck.php';

    include 'data.php';

    $pageTitle = 'Klienta informācija';

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
                    <th>Vārds/Nosaukums: </th>
                    <th><?php echo $row[$keys[0]] ?></th>
                </tr>
                <tr>
                    <th>E-pasts: </th>
                    <th><?php echo $row[$keys[1]] ?></th>
                </tr>
                <tr>
                    <th>Telefona numurs: </th>
                    <th><?php echo $row[$keys[2]] ?></th>
                </tr>
                <tr>
                    <th>Adrese: </th>
                    <th><?php echo $row[$keys[3]] ?></th>
                </tr>
            </table>
        <?php
    }

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/readPage.php';
?>