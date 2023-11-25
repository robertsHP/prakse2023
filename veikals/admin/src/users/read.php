<?php 
    $redirectPath = '/veikals/admin/index.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/sessionCheck.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/tempCheck.php';

    include 'data.php';

    $pageTitle = null;

    $id = null;
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $pageTitle = "Lietotāja informācija";
    } else {
        $id = $_SESSION["id"];
        $pageTitle = "Konts";
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
                    <th>Vārds: </th>
                    <th><?php echo $row[$keys[0]] ?></th>
                </tr>
                <tr>
                    <th>Uzvārds: </th>
                    <th><?php echo $row[$keys[1]] ?></th>
                </tr>
                <tr>
                    <th>E-pasts: </th>
                    <th><?php echo $row[$keys[2]] ?></th>
                </tr>
            </table>
        <?php
    }

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/readPage.php';
?>