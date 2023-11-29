
<tr>
    <td>
        <button id="editable-table-add-button">pievienot</button>
    </td>
</tr>

<div id="button-response"></div>

<script>
    $(document).ready(function () {
        var clickCount = <?php echo json_encode($rowCount); ?>

        $('#editable-table-add-button').click(function(){
            clickCount++;
            $.ajax({
                url: '/veikals/admin/src/orders/editableTable/loadEmptyRow.php',
                method: 'POST',
                data: { 
                    'rowCount': clickCount,
                    'productsData': <?php echo json_encode($productsData); ?>
                },
                success: function(response) {
                    //Pievieno rindu
                    $('#editable-table tr:last').before(response);
                },
                error: function(error) {
                    console.error('Error loading content:', error);
                }
            });
        });
    });
</script>