
<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormDataType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/TagLoader.php';

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
            <?php
                $tagName = $keys[1].$rowCount;
                $variableData = $row[$keys[1]];
            ?>
            <input 
                type="text" 
                value="<?php echo $variableData; ?>"
                id="<?php echo $tagName; ?>"
            >
            <?php 
                TagLoader::loadInputErrorMessage($tagName, $variableData);
            ?>
        </td>
        <td>
            <?php
                $tagName = $keys[2].$rowCount;
                $variableData = $row[$keys[2]];
            ?>
            <textarea 
                rows="6" 
                cols="30"
                id="<?php echo $tagName; ?>"
            ><?php echo $variableData; ?></textarea>
            <?php 
                TagLoader::loadInputErrorMessage($tagName, $variableData);
            ?>
        </td>
        <td>
            <?php
                $tagName = $keys[3].$rowCount;
                $variableData = $row[$keys[3]];
            ?>
            <?php 
                $elementValue = $variableData;
                $allowedFileFormats = $productsData['form-data'][$productsDataKeys[2]]['allowed_file_formats'];

                include 'miniImageSelectElement.php';
            ?>
            <?php 
                TagLoader::loadInputErrorMessage($tagName, $variableData);
            ?>
        </td>
        <td>
            <?php
                $tagName = $keys[4].$rowCount;
                $variableData = $row[$keys[4]];
            ?>
            <input 
                type="number" 
                id="<?php echo $tagName; ?>"
                value="<?php echo $variableData; ?>"
                step=".01"
            >
            <?php 
                TagLoader::loadInputErrorMessage($tagName, $variableData);
            ?>
        </td>
        <td>
            <?php
                $tagName = $keys[5].$rowCount;
                $variableData = $row[$keys[5]];
            ?>
            <input 
                type="number" 
                id="<?php echo $tagName; ?>"
                value="<?php echo $variableData; ?>"
            >
            <?php 
                TagLoader::loadInputErrorMessage($tagName, $variableData);
            ?>
        </td>
        <td>
        <?php
                $tagName = $keys[6].$rowCount;
                $variableData = $row[$keys[6]];
            ?>
            <select 
                id="<?php echo $tagName; ?>"
                value="<?php echo $variableData; ?>">
                <?php
                    $catRows = Database::getAllRowsFrom('product_categories');
                    foreach ($catRows as $catRow) {
                        $selected = $catRow['category_id'] == $variableData ? ' selected' : '';
                        echo '<option 
                            value="'.$catRow['category_id'].'"
                            '.$selected.'
                        >'.$catRow['name'].'</option>';
                    }
                ?>
            </select>
            <?php 
                TagLoader::loadInputErrorMessage($tagName, $variableData);
            ?>
        </td>
    </form>
</tr>