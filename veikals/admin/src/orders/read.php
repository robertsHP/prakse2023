<?php 
    $redirectPath = '/veikals/admin/index.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/sessionCheck.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/tempCheck.php';

    include 'data.php';

    $pageTitle = 'Pasūtījumi';

    if (isset($_GET['id'])) {
        $data['id'] = $_GET['id'];
    }

    function displayData ($idColumnName, $data, $row) {
        $keys = array_keys($data);
        ?>
            <table class="table table-hover">
                <tr>
                    <th>ID: </th>
                    <th><?php echo $row[$idColumnName] ?></th>
                </tr>
                <tr>
                    <th>Numurs: </th>
                    <th><?php echo $row[$keys[0]] ?></th>
                </tr>
                <tr>
                    <th>Klients: </th>
                    <th>
                        <?php 
                            $catRow = Database::getRowWithID(
                                'clients', 
                                $keys[1], 
                                $row[$keys[1]]);
                            echo $catRow['name'];
                        ?>
                    </th>
                </tr>
                <tr>
                    <th>Datums: </th>
                    <th><?php echo $row[$keys[2]] ?></th>
                </tr>
                <tr>
                    <th>Cena: </th>
                    <th><?php echo $row[$keys[3]].' eiro' ?></th>
                </tr>
                <tr>
                    <th>Statuss: </th>
                    <th>
                        <?php 
                            $catRow = Database::getRowWithID(
                                'order_states', 
                                $keys[4], 
                                $row[$keys[4]]);
                            echo $catRow['name'];
                        ?>
                    </th>
                </tr>
                <tr>
                    <th>Preces: </th>
                    <th>
                        <?php
                            $rows = null;
                            try {
                                $conn = Database::openConnection();
            
                                $stmt = $conn->prepare(
                                    "SELECT * FROM products WHERE product_id IN (SELECT product_id FROM purchased_goods WHERE order_id=:id);"
                                );
                                $stmt->bindParam(':id', $row[$idColumnName], PDO::PARAM_INT);
                                $stmt->execute();
                                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                Database::closeConnection($conn);

                                if(count($rows) != 0) {
                                    ?>
                                    <table class="table table-hover">
                                        <thead class="thead-custom">
                                            <tr>
                                                <th>ID</th>
                                                <?php
                                                    //Iegūst produktu datus
                                                    $originalData = $data;
                                                    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/products/data.php';
                                                    $productsData = $data;
                                                    $data = $originalData;
            
                                                    foreach ($productsData['form-data'] as $column)
                                                        if (isset($column['title']))
                                                            echo '<th>'.$column['title'].'</th>';
                                                    echo '<th></th>';
                                                ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if(count($rows) != 0) {
                                                    include 'editableTable/rowLoader.php';
            
                                                    $keys = array_keys($rows[0]);
                                                    
                                                    foreach ($rows as $row) {
                                                        $productsData['id'] = $row[$productsData['id-column-name']];
                                                        foreach ($productsData['form-data'] as $key => &$var) {
                                                            $var['value'] = $row[$key];
                                                        }
                                                        loadUneditableRow($productsData, $keys, $rowCount);
                                                        $rowCount++;
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                    <?php
                                } else {
                                    echo 'Nav neviens produkts';
                                }
                                                
                            } catch (PDOException $exception) {
                                echo "PDO Exception: " . $exception->getMessage();
                                echo "Error Code: " . $exception->getCode();
                            }
                        ?> 
                    </th>
                </tr>
            </table>
        <?php
    }

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/readPage.php';
?>