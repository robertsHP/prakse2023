
<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/Database.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['productsData']) && isset($_POST['rowCount'])) {
            $productsData = $_POST['productsData'];
            $rowCount = $_POST['rowCount'];

            $rows = Database::getAllRowsFrom($productsData['table-name']);
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
                                    console.log(clickCount);
                                });
                            </script>
                        </td>
                        <td></td>
                        <td>
                            <input 
                                type="text" 
                                id="<?php echo $keys[1].$rowCount; ?>"
                                value="">
                        </td>
                        <td>
                            <textarea 
                                rows="6" 
                                cols="30"
                                id="<?php echo $keys[2].$rowCount; ?>"
                            ></textarea>
                        </td>
                        <td>
                            <?php 
                                include 'miniImageSelectElement.php';
                            ?>
                        </td>
                        <td>
                            <input 
                                type="number" 
                                value=""
                                step=".01"
                                id="<?php echo $keys[4].$rowCount; ?>"
                            >
                        </td>
                        <td>
                            <input 
                                type="number" 
                                value=""
                                id="<?php echo $keys[5].$rowCount; ?>"
                            >
                        </td>
                        <td>
                            <select 
                                value=""
                                id="<?php echo $keys[6].$rowCount; ?>">
                                <?php
                                    $catRows = Database::getAllRowsFrom('product_categories');
                                    foreach ($catRows as $row) {
                                        echo '<option 
                                            value="'.$row['category_id'].'"
                                        >'.$row['name'].'</option>';
                                    }
                                ?>
                            </select>
                        </td>
                    </form>
                </tr>
            <?php

        }
    }
?>