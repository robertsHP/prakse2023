
<?php
    function loadEditableRow (&$data, &$keys, &$rowCount) {
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
                            });
                        </script>
                    </td>
                    <td>
                        <?php
                            $tagName = $keys[0].$rowCount;
                            $variableData = isset($data['id']) ? $data['id'] : '';
                        ?>
                        <p id="<?php echo $tagName; ?>">
                            <?php echo $variableData; ?>
                        </p>
                    </td>
                    <td>
                        <?php
                            $tagName = $keys[1].$rowCount;
                            $variableData = $data['form-data'][$keys[1]];
                        ?>
                        <input 
                            type="text" 
                            id="<?php echo $tagName; ?>"
                            value="<?php 
                                if(isset($variableData['value']))
                                    echo $variableData['value'];
                            ?>">
                        <?php 
                            TagLoader::loadInputErrorMessage($tagName, $variableData);
                        ?>
                    </td>
                    <td>
                        <?php
                            $tagName = $keys[2].$rowCount;
                            $variableData = $data['form-data'][$keys[2]];
                        ?>
                        <textarea 
                            rows="6" 
                            cols="30"
                            id="<?php echo $tagName; ?>"
                        ><?php 
                                if(isset($variableData['value']))
                                    echo $variableData['value'];
                        ?></textarea>
                        <?php 
                            TagLoader::loadInputErrorMessage($tagName, $variableData);
                        ?>
                    </td>
                    <td>
                        <?php
                            $tagName = $keys[3].$rowCount;
                            $variableData = $data['form-data'][$keys[3]];
                        ?>
                        <?php 
                            include 'miniImageSelectElement.php';
                        ?>
                        <?php 
                            TagLoader::loadInputErrorMessage($tagName, $variableData);
                        ?>
                    </td>
                    <td>
                        <?php
                            $tagName = $keys[4].$rowCount;
                            $variableData = $data['form-data'][$keys[4]];
                        ?>
                        <input 
                            type="number" 
                            value="<?php 
                                if(isset($variableData['value']))
                                    echo $variableData['value'];
                            ?>"
                            step=".01"
                            id="<?php echo $tagName; ?>"
                        >
                        <?php 
                            TagLoader::loadInputErrorMessage($tagName, $variableData);
                        ?>
                    </td>
                    <td>
                        <?php
                            $tagName = $keys[5].$rowCount;
                            $variableData = $data['form-data'][$keys[5]];
                        ?>
                        <input 
                            type="number" 
                            value="<?php 
                                if(isset($variableData['value']))
                                    echo $variableData['value'];
                            ?>"
                            id="<?php echo $tagName; ?>"
                        >
                        <?php 
                            TagLoader::loadInputErrorMessage($tagName, $variableData);
                        ?>
                    </td>
                    <td>
                        <?php
                            $tagName = $keys[6].$rowCount;
                            $variableData = $data['form-data'][$keys[6]];
                        ?>
                        <select 
                            value="<?php 
                                if(isset($variableData['value']))
                                    echo $variableData['value'];
                            ?>"
                            id="<?php echo $tagName; ?>">
                            <?php
                                $catRows = Database::getAllRowsFrom('product_categories');
                                foreach ($catRows as $row) {
                                    $selected = $row[$keys[6]] == $variableData['value'] ? ' selected' : '';
                                    echo $selected;
                                    echo '<option 
                                        value="'.$row['category_id'].'"
                                        '.$selected.'
                                    >'.$row['name'].'</option>';
                                }
                            ?>
                        </select>
                        <?php 
                            TagLoader::loadInputErrorMessage($tagName, $variableData);
                        ?>
                    </td>
                </form>
                <script>
                    var errorTags = <?php echo json_encode($data['form-data']); ?>;
                    var rowCount = <?php echo json_encode($rowCount); ?>;
                    
                    $.each(errorTags, function(index, value) {
                        $("#"+index+rowCount+"-alert").hide();
                    });
                </script>
            </tr>
        <?php 
    }

    function loadUneditableRow (&$data, &$keys, &$rowCount) {
        ?>
            <tr id="editable-table-row-<?php echo $rowCount; ?>">
                <td>
                    <?php
                        if(isset($data['id']))
                            echo $data['id'];
                    ?>
                </td>
                <td>
                    <?php
                        print_r($data['form-data'][$keys[1]]['value']);

                        if(isset($data['form-data'][$keys[1]]))
                            echo $data['form-data'][$keys[1]]['value'];
                    ?>
                </td>
                <td>
                    <?php
                        if(isset($data['form-data'][$keys[2]]))
                            echo $data['form-data'][$keys[2]]['value'];
                    ?>
                </td>
                <td>
                    <img 
                        src="<?php 
                            if(isset($data['form-data'][$keys[3]]))
                                echo $data['form-data'][$keys[3]]['value'];
                        ?>" 
                        name="photo_file_loc"
                        id="photo_file_loc"
                        class="img-thumbnail img-product-photo" 
                        alt="">
                </td>
                <td>
                    <?php
                        if(isset($data['form-data'][$keys[4]]))
                            echo $data['form-data'][$keys[4]]['value'];
                    ?>
                </td>
                <td>
                <?php
                        if(isset($data['form-data'][$keys[5]]))
                            echo $data['form-data'][$keys[5]]['value'];
                    ?>
                </td>
                <td>
                    <?php 
                        $catRow = Database::getRowWithID(
                            'product_categories', 
                            $keys[6], 
                            $data['form-data'][$keys[6]]['value']);
                        echo $catRow['name'];
                    ?>

                </td>
            </tr>
        <?php
    }
?>