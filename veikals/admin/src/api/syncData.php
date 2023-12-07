
<?php 
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/sessionCheck.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/tempCheck.php';
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/CRUDTable.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/CRUDOptions.php';
?>

<!DOCTYPE html>
<html lang="en">  
    <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/head.php'; ?>
    <body>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/header.php'; ?>
        <div class="main-container">
            <h4>Atjaunot datus</h4>
            <button
                type="button"
                id="api-button"
                class="btn btn-primary execution-button"
            >API call</button>

            <div id="result"></div>

            <script>
                $(document).ready(function () {
                    $('#api-button').click(function () {
                        // $.ajax({
                        //     type: 'POST',
                        //     url: '/veikals/admin/src/api/refreshCall.php',
                        // })
                        // .done(function(response) {
                        //     $('#result').html(response);
                        // })
                        // .fail(function(error) {
                        //     console.error("AJAX request failed:", error);
                        // });
                        $.ajax({
                            url: '/veikals/admin/src/api/refreshCall.php',
                            type: 'POST',
                            success: function(response) {
                                $('#result').html(response);
                            },
                            error: function(xhr, status, error) {
                                console.error("AJAX request failed:", error);
                            }
                        });
                    });
                });
            </script>
        </div>
    </body>
</html>