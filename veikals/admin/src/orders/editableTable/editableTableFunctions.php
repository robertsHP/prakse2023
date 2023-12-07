<?php
    function populateProductDataWithRow (&$data, $row) {
        $data['id'] = $row[$data['id-column-name']];
        foreach ($data['form-data'] as $key => &$var) {
            $var['value'] = $row[$key];
        }
    }
    function populatePurchGoods ($orderID, $productID, &$data) {
        $rows = null;
        try {
            $conn = Database::openConnection();

            $stmt = $conn->prepare(
                "SELECT * FROM purchased_goods WHERE order_id=:order_id AND product_id=:product_id"
            );
            $stmt->bindParam(':order_id', $orderID, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $productID, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            Database::closeConnection($conn);

            if($row != null) {
                $data['id'] = $row['purch_goods_id'];
                foreach ($data['form-data'] as $key => &$var) {
                    $var['value'] = $row[$key];
                }
            }

        } catch (PDOException $exception) {
            echo "PDO Exception: " . $exception->getMessage();
            echo "Error Code: " . $exception->getCode();
        }
        return $rows;
    }
    function getProductRow ($productID) {
        $row = null;
        try {
            $conn = Database::openConnection();

            $stmt = $conn->prepare(
                "SELECT * FROM products WHERE product_id=:id"
            );
            $stmt->bindParam(':id', $productID, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            Database::closeConnection($conn);
        } catch (PDOException $exception) {
            echo "PDO Exception: " . $exception->getMessage();
            echo "Error Code: " . $exception->getCode();
        }
        return $row;
    }
    function getOrderProducts ($orderID) {
        $rows = null;
        try {
            $conn = Database::openConnection();

            $stmt = $conn->prepare(
                "SELECT * FROM products WHERE product_id IN 
                    (SELECT product_id FROM purchased_goods WHERE order_id=:id);"
            );
            $stmt->bindParam(':id', $orderID, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            Database::closeConnection($conn);
        } catch (PDOException $exception) {
            echo "PDO Exception: " . $exception->getMessage();
            echo "Error Code: " . $exception->getCode();
        }
        return $rows;
    }
    function getProductsThatArentLinkedWithOrder ($orderID) {
        $rows = null;
        try {
            $conn = Database::openConnection();

            $stmt = $conn->prepare(
                "SELECT * FROM products WHERE NOT EXISTS (
                    SELECT 1 FROM purchased_goods 
                    WHERE purchased_goods.product_id = products.product_id 
                    AND purchased_goods.order_id = :orderID);"
            );
            $stmt->bindParam(':orderID', $orderID, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            Database::closeConnection($conn);
        } catch (PDOException $exception) {
            echo "PDO Exception: " . $exception->getMessage();
            echo "Error Code: " . $exception->getCode();
        }
        return $rows;
    }
    function loadProductColumns ($formData) {
        ?> <th>ID</th> <?php
        foreach ($formData as $column)
            if (isset($column['title']))
                echo '<th>'.$column['title'].'</th>';
        ?> <th>Pasūtītais daudzums</th> <?php
        ?> <th>Kopējā cena</th> <?php
        
    }
    function loadEditableRow (&$productsData, &$purchGoodsData, &$rowCount, $editable) {
        $productsKeys = array_keys($productsData['form-data']);
        $purchGoodsKeys = array_keys($purchGoodsData['form-data']);
        $errorTags = [];

        ?>
            <tr id="editable-table-row-<?php echo $rowCount; ?>">
                <form class="editable-table-row-form" enctype="multipart/form-data">
                    <td>
                        <button id="<?php echo 'editable-table-delete-button-'.$rowCount; ?>">noņemt</button>
                        <script>
                            //Dzēšanas poga
                            $('#editable-table-delete-button-'+<?php echo json_encode($rowCount); ?>).click(function () {
                                var clickCount = <?php echo json_encode($rowCount); ?>;
                                var id = "<?php echo $productsData['id'] ?>";
                                var text = "<?php echo $productsData['form-data'][$productsKeys[1]]['value'] ?>";

                                if(id != "") {
                                    $('editable-table-add-selection').append(
                                        $("<option>").val(id).text(text)
                                    );
                                }
                                $('#editable-table-row-'+clickCount).remove();
                            });
                        </script>
                    </td>
                    <td>
                        <?php
                            $tagName = $productsData['id-column-name'].$rowCount;
                            $variableData = isset($productsData['id']) ? $productsData['id'] : '';
                        ?>
                        <p id="<?php echo $tagName; ?>">
                            <?php echo $variableData; ?>
                        </p>
                    </td>
                    <td>
                        <?php
                            $tagName = $productsKeys[0].$rowCount;
                            $variableData = $productsData['form-data'][$productsKeys[0]];
                        ?>
                        <input 
                            <?php echo $editable ? '' : 'disabled' ?>
                            style="width: 150px;"
                            type="text" 
                            id="<?php echo $tagName; ?>"
                            value="<?php 
                                if(isset($variableData['value']))
                                    echo $variableData['value'];
                            ?>">
                        <?php 
                            $errorTags[] = TagLoader::loadInputErrorMessage($tagName, $variableData);
                        ?>
                    </td>
                    <td>
                        <?php
                            $tagName = $productsKeys[1].$rowCount;
                            $variableData = $productsData['form-data'][$productsKeys[1]];
                        ?>
                        <textarea 
                            <?php echo $editable ? '' : 'disabled' ?>
                            rows="6" 
                            cols="30"
                            id="<?php echo $tagName; ?>"
                        ><?php 
                                if(isset($variableData['value']))
                                    echo $variableData['value'];
                        ?></textarea>
                        <?php 
                            $errorTags[] = TagLoader::loadInputErrorMessage($tagName, $variableData);
                        ?>
                    </td>
                    <td>
                        <?php
                            $tagName = $productsKeys[2].$rowCount;
                            $variableData = $productsData['form-data'][$productsKeys[2]];
                        ?>
                        <?php 
                            include 'miniImageSelectElement.php';
                        ?>
                        <?php 
                            $errorTags[] = TagLoader::loadInputErrorMessage($tagName, $variableData);
                        ?>
                    </td>
                    <td>
                        <?php
                            $tagName = $productsKeys[3].$rowCount;
                            $variableData = $productsData['form-data'][$productsKeys[3]];
                        ?>
                        <input 
                            <?php echo $editable ? '' : 'disabled' ?>
                            style="width: 80px;"
                            type="number" 
                            value="<?php 
                                if(isset($variableData['value']))
                                    echo $variableData['value'];
                            ?>"
                            step=".01"
                            id="<?php echo $tagName; ?>"
                        >
                        <?php 
                            $errorTags[] = TagLoader::loadInputErrorMessage($tagName, $variableData);
                        ?>
                    </td>
                    <td>
                        <?php
                            $tagName = $productsKeys[4].$rowCount;
                            $variableData = $productsData['form-data'][$productsKeys[4]];
                        ?>
                        <input 
                            <?php echo $editable ? '' : 'disabled' ?>
                            style="width: 150px;"
                            type="number" 
                            value="<?php 
                                if(isset($variableData['value']))
                                    echo $variableData['value'];
                            ?>"
                            id="<?php echo $tagName; ?>"
                        >
                        <?php 
                            $errorTags[] = TagLoader::loadInputErrorMessage($tagName, $variableData);
                        ?>
                    </td>
                    <td>
                        <?php
                            $tagName = $productsKeys[5].$rowCount;
                            $variableData = $productsData['form-data'][$productsKeys[5]];
                        ?>
                        <select 
                            <?php echo $editable ? '' : 'disabled' ?>
                            style="width: 150px;"
                            value="<?php 
                                if(isset($variableData['value']))
                                    echo $variableData['value'];
                            ?>"
                            id="<?php echo $tagName; ?>">
                            <?php
                                $catRows = Database::getAllRowsFrom('product_categories');
                                foreach ($catRows as $row) {
                                    $selected = $row[$productsKeys[5]] == $variableData['value'] ? ' selected' : '';
                                    echo $selected;
                                    echo '<option 
                                        value="'.$row['category_id'].'"
                                        '.$selected.'
                                    >'.$row['name'].'</option>';
                                }
                            ?>
                        </select>
                        <?php 
                            $errorTags[] = TagLoader::loadInputErrorMessage($tagName, $variableData);
                        ?>
                    </td>
                    <td>
                        <?php
                            $tagName = $purchGoodsKeys[2].$rowCount;
                            $variableData = $purchGoodsData['form-data'][$purchGoodsKeys[2]];
                        ?>
                        <input 
                            style="width: 150px;"
                            type="number" 
                            value="<?php 
                                if(isset($variableData['value']))
                                    echo $variableData['value'];
                            ?>"
                            id="<?php echo $tagName; ?>"
                        >
                        <?php 
                            $errorTags[] = TagLoader::loadInputErrorMessage($tagName, $variableData);
                        ?>
                    </td>
                    <td>
                        <?php
                            $tagName = $purchGoodsKeys[3].$rowCount;
                            $variableData = $purchGoodsData['form-data'][$purchGoodsKeys[3]];
                        ?>
                        <input 
                            style="width: 80px;"
                            type="number" 
                            value="<?php 
                                if(isset($variableData['value']))
                                    echo $variableData['value'];
                            ?>"
                            step=".01"
                            id="<?php echo $tagName; ?>"
                        >
                        <?php 
                            $errorTags[] = TagLoader::loadInputErrorMessage($tagName, $variableData);
                        ?>
                    </td>
                </form>
                <script>
                    var errorTags = <?php echo json_encode($errorTags); ?>;
                    var rowCount = <?php echo json_encode($rowCount); ?>;
                    
                    $.each(errorTags, function(index, value) {
                        $('#'+value).hide();
                    });
                </script>
            </tr>
        <?php 
    }
    function loadUneditableRow (&$productsData, &$purchGoodsData, &$rowCount) {
        $productsKeys = array_keys($productsData['form-data']);
        $purchGoodsKeys = array_keys($purchGoodsData['form-data']);

        ?>
            <tr id="editable-table-row-<?php echo $rowCount; ?>">
                <td>
                    <?php
                        if(isset($productsData['id']))
                            echo $productsData['id'];
                    ?>
                </td>
                <td>
                    <?php
                        if(isset($productsData['form-data'][$productsKeys[0]]))
                            echo $productsData['form-data'][$productsKeys[0]]['value'];
                    ?>
                </td>
                <td>
                    <?php
                        if(isset($productsData['form-data'][$productsKeys[1]]))
                            echo $productsData['form-data'][$productsKeys[1]]['value'];
                    ?>
                </td>
                <td>
                    <img 
                        src="<?php 
                            if(isset($productsData['form-data'][$productsKeys[2]]))
                                echo $productsData['form-data'][$productsKeys[2]]['value'];
                        ?>" 
                        name="photo_file_loc"
                        id="photo_file_loc"
                        class="img-thumbnail img-product-photo" 
                        alt="">
                </td>
                <td>
                    <?php
                        if(isset($productsData['form-data'][$productsKeys[3]]))
                            echo $productsData['form-data'][$productsKeys[3]]['value'];
                    ?>
                </td>
                <td>
                <?php
                        if(isset($productsData['form-data'][$productsKeys[4]]))
                            echo $productsData['form-data'][$productsKeys[4]]['value'];
                    ?>
                </td>
                <td>
                    <?php 
                        $catRow = Database::getRowWithID(
                            'product_categories', 
                            $productsKeys[5], 
                            $productsData['form-data'][$productsKeys[5]]['value']);
                        echo $catRow['name'];
                    ?>

                </td>
                <td>
                    <?php
                        if(isset($purchGoodsData['form-data'][$purchGoodsKeys[2]]))
                            echo $purchGoodsData['form-data'][$purchGoodsKeys[2]]['value'];
                    ?>
                </td>
                <td>
                    <?php
                        if(isset($purchGoodsData['form-data'][$purchGoodsKeys[3]]))
                            echo $purchGoodsData['form-data'][$purchGoodsKeys[3]]['value'];
                    ?>
                </td>
            </tr>
        <?php
    }
?>