
<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormDataType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/TagLoader.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/Database.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['productsData']) && isset($_POST['rowCount'])) {
            $data = $_POST['productsData'];
            $rowCount = $_POST['rowCount'];

            $rows = Database::getAllRowsFrom($data['table-name']);
            $keys = array_keys($rows[0]);
            $elementValue = null;

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
                        <td></td>
                        <td>
                            <?php
                                $tagName = $keys[1].$rowCount;
                                $variableData = $data['form-data'][$keys[1]];
                            ?>
                            <input 
                                type="text" 
                                id="<?php echo $tagName; ?>"
                                value="">
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
                            ></textarea>
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
                                value=""
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
                                value=""
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
                                value=""
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
                        var errorTags = <?php echo json_encode($data['form-data']); ?>;
                        var rowCount = <?php echo json_encode($rowCount); ?>;

                        $(document).ready(function () {
                            $.each(errorTags, function(index, value) {
                                $("#"+index+rowCount+"-alert").hide();
                            });
                        });
                    </script>
                </tr>
            <?php

        }
    }
    // header('Content-Type: application/json');
    // echo json_encode($response);
?>