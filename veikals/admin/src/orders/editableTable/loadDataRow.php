
<?php
    $keys = array_keys($row);

?>

<tr id="editable-table-row-<?php echo $rowCount; ?>">
    <form class="editable-table-row-form" enctype="multipart/form-data">
        <td>
            <button id="<?php echo 'editable-table-delete-button-'.$rowCount; ?>">noņemt</button>
            <script>
                //Dzēšanas poga
                $('#editable-table-delete-button-'+<?php echo json_encode($rowCount); ?>).click(function () {
                    var clickCount = <?php echo json_encode($rowCount); ?>;
                    $('#editable-table-row-'+clickCount).remove();
                    console.log(clickCount);
                });
            </script>
        </td>
        <td><?php echo $row[$keys[0]]; ?></td>
        <td>
            <input 
                type="text" 
                value="<?php echo $row[$keys[1]]; ?>"
                id="<?php echo $keys[1].$rowCount; ?>"
            >
        </td>
        <td>
            <textarea 
                rows="6" 
                cols="30"
                id="<?php echo $keys[2].$rowCount; ?>"
            ><?php echo $row[$keys[2]]; ?></textarea>
        </td>
        <td>
            <?php 
                $elementValue = $row[$keys[3]];
                $allowedFileFormats = $productsData['form-data'][$productsDataKeys[2]]['allowed_file_formats'];

                include 'miniImageSelectElement.php';
            ?>
        </td>
        <td>
            <input 
                type="number" 
                id="<?php echo $keys[4].$rowCount; ?>"
                value="<?php echo $row[$keys[4]]; ?>"
                step=".01"
            >
        </td>
        <td>
            <input 
                type="number" 
                id="<?php echo $keys[5].$rowCount; ?>"
                value="<?php echo $row[$keys[5]]; ?>"
            >
        </td>
        <td>
            <select 
                id="<?php echo $keys[6].$rowCount; ?>"
                value="<?php echo $row[$keys[6]]; ?>">
                <?php
                    $catRows = Database::getAllRowsFrom('product_categories');
                    foreach ($catRows as $catRow) {
                        $selected = $catRow['category_id'] == $row[$keys[6]] ? ' selected' : '';
                        echo '<option 
                            value="'.$catRow['category_id'].'"
                            '.$selected.'
                        >'.$catRow['name'].'</option>';
                    }
                ?>
            </select>
        </td>
    </form>
</tr>