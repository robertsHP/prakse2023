
<tr>
    <td>
        <button id="editable-table-add-button">add</button>
    </td>
</tr>

<script>
    function createCounter() {
        let count = 0;

        return function() {
            return count++;
        };
    }
    const editableTableAddCounter = createCounter();

    $(document).ready(function () {
        $('#editable-table-add-button').click(function(){
            $.ajax({
                url: '/veikals/admin/src/orders/editableTable/loadEmptyRow.php',
                method: 'POST',
                data: { 
                    'count': editableTableAddCounter(),
                    'productData': <?php echo json_encode($data); ?>
                },
                success: function(response) {
                    // Update a specific element on your page with the Ajax response
                    $('#editable-table tr:last').before(response);

                    // Manually submit the form after the Ajax request
                    //   form.unbind('submit').submit();


                    // $('#editable-table tr:last').unbind('submit').submit();
                    // $('#editable-table tr:last').before(response);
                },
                error: function(error) {
                    console.error('Error loading content:', error);
                }
            });
        });
    });
</script>