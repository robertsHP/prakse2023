
<?php
    //Iegūst produktu datus
    $originalData = $data;
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/products/data.php';
    $newData = $data;
    $data = $originalData;

    $newDataKeys = array_keys($newData['form-data']);

    $rowCount = 0;
?>

<div style="overflow-y: scroll; height:300px;">
    <table class="table table-hover" id="editable-table">
        <thead class="thead-custom">
            <tr>
                <th></th>
                <th>ID</th>
                <?php
                    foreach ($newData['form-data'] as $column)
                        if (isset($column['title']))
                            echo '<th>'.$column['title'].'</th>';
                    echo '<th></th>';
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
                $rows = Database::getAllRowsFrom($newData['table-name']);
                if($originalData['id'] != null) {
                    foreach ($rows as $row) {
                        include 'loadDataRow.php';
                        $rowCount++;
                    }
                }
                include 'loadAddRowButton.php';
            ?> 
        </tbody>
    </table>
</div>