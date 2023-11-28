
<div style="overflow-y: scroll; height:300px;">
    <table class="table table-hover" id="editable-table">
        <?php
            $columnNames = [];
            foreach ($data['form-data'] as $column)
                if (isset($column['title']))
                    $columnNames[] = $column['title'];
            ?>
            <thead class="thead-custom">
                <tr>
                    <th></th>
                    <th>ID</th>
                    <?php
                        foreach ($columnNames as $name)
                            echo '<th>'.$name.'</th>';
                        echo '<th></th>';
                    ?>
                </tr>
            </thead>
            <?php
                $id = isset($_GET['id']) ? $_GET['id'] : null;
                $rows = Database::getAllRowsFrom($data['table-name']);
                $dataKeys = array_keys($data['form-data']);
            ?>
            <tbody>
                <?php
                    if($id != null) {
                        $index = 0;
                        foreach ($rows as $row) {
                            $rowKeys = array_keys($row);
                            include 'loadDataRow.php';
                            $index++;
                        }
                    }
                    include 'loadAddRowButton.php';
                ?> 
            </tbody>
    </table>
</div>