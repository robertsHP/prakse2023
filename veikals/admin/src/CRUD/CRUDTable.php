<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/Database.php';

    class CRUDTable {
        public static function load (array $columns, string $tableName) {
            $dbResult = Database::getAllRowsFrom($tableName);

            if(!empty($dbResult)) {
                ?>
                    <table class="table table-hover" id="index-table">
                        <thead class="thead-custom">
                            <tr>
                                <?php
                                    foreach ($columns as $key => $column)
                                        echo '<th>'.$key.'</th>';
                                    echo '<th></th>';
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php CRUDTable::loadData($dbResult, $columns); ?>
                        </tbody>
                    </table>
                <?php
            }
        }
        private static function loadData (array $dbResult, array $columns) {

            foreach ($dbResult as $row) {
                $keys = array_keys($row);
                $id = $row[$keys[0]];
                echo '<tr>';
                    foreach ($columns as $column) {
                        //Ja ir aivietojama vērtība
                        if (isset($column['value-swap-info'])) {
                            $colName = $column['col-name'];
                            $swapTable = $column['value-swap-info']['swap-table'];
                            $swapColName = $column['value-swap-info']['swap-col-name'];

                            //Ar ID dabū konkrētās rindas datus ar kuriem aizvietot mainīgo
                            $swapRow = Database::getRowWithID($swapTable, $colName, $row[$column['col-name']]);
                            echo empty($swapRow) ? 
                                '<td></td>' 
                                : 
                                '<td>'.$swapRow[$swapColName].'</td>';
                        //Ja ir parasta vērtība
                        } else if (isset($column['col-name'])) {
                            echo '<td>'.$row[$column['col-name']].'</td>';
                        } else {
                            echo '<td></td>';
                        }
                    }
                    CRUDTable::loadIndexButtons($id);
                echo '</tr>';
            }
        }
        private static function loadIndexButtons ($rowID) {
            ?>
                <td>
                    <a class="icon-button" href="read.php?id=<?php echo $rowID; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                        </svg>
                    </a>
                    <a class="icon-button" href="update.php?id=<?php echo $rowID; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                        </svg>
                    </a>
                    <a class="icon-button" href="delete.php?id=<?php echo $rowID; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                        </svg>
                    </a>
                </td>
            <?php
        }
    }
?>