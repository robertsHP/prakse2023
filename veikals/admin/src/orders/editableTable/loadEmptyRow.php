


<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['productData']) && isset($_POST['count'])) {
            $data = $_POST['productData'];
            $count = $_POST['count'];

            include 'MiniImageSelectElement.php';

            $dataKeys = array_keys($data['form-data']);

            echo 'pain';

            ?>
                <tr>
                    <td><input value="noņemt" type='button'/></td>
                    <td></td>
                    <td>
                        <input type="text" value="">
                    </td>
                    <td>
                        <textarea 
                            rows="6" 
                            cols="30"
                        ></textarea>
                    </td>
                    <td>
                        <?php 
                            $tagName = 'temp-row-'.$count;
                            $elementValue = null;
                            $allowedFileFormats = $data['form-data'][$dataKeys[2]]['allowed_file_formats'];

                            include 'miniImageSelectElement.php';
                        ?>
                    </td>
                    <td>
                        <input 
                            type="number" 
                            value=""
                            step=".01"
                        >
                    </td>
                    <td>
                        <input 
                            type="number" 
                            value=""
                        >
                    </td>
                    <td>
                        <select 
                            value="">
                            <?php
                                $catRows = Database::getAllRowsFrom('product_categories');
                                foreach ($catRows as $catRow) {
                                    $selected = $catRow[$tagName] == $variableData['value'] ? ' selected' : '';
                                    echo '<option 
                                        value="'.$catRow[$tagName].'"
                                        '.$selected.'
                                    >'.$catRow['name'].'</option>';
                                }
                            ?>
                        </select>
                    </td>
                </tr>
            <?php

        }
    }
?>