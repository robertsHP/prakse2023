
<?php
    function loadRow (&$rowData, &$keys, &$rowCount) {
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
                            $variableData = isset($rowData['id']) ? $rowData['id'] : '';
                        ?>
                        <p id="<?php echo $tagName; ?>">
                            <?php echo $variableData; ?>
                        </p>
                    </td>
                    <td>
                        <?php
                            $tagName = $keys[1].$rowCount;
                            $variableData = $rowData['form-data'][$keys[1]];
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
                            $variableData = $rowData['form-data'][$keys[2]];
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
                            $variableData = $rowData['form-data'][$keys[3]];
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
                            $variableData = $rowData['form-data'][$keys[4]];
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
                            $variableData = $rowData['form-data'][$keys[5]];
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
                            $variableData = $rowData['form-data'][$keys[6]];
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
                                    echo '<option 
                                        value="'.$row['category_id'].'"
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
                    var errorTags = <?php echo json_encode($rowData['form-data']); ?>;
                    var rowCount = <?php echo json_encode($rowCount); ?>;
                    
                    $.each(errorTags, function(index, value) {
                        $("#"+index+rowCount+"-alert").hide();
                    });
                </script>
            </tr>
        <?php
    }
?>