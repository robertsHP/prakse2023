<?php
    require_once 'editableTableFunctions.php';
?>

<tr>
    <td>
        <select id="editable-table-add-selection" style="width: 100px;">
            <option value="empty">--Tukšu--</option>
            <?php
                $rows = getProductsThatArentLinkedWithOrder($data['id']);
                foreach ($rows as $row) {
                    echo '<option value="'.$row['product_id'].'">'.$row['name'].'</option>';
                }
            ?>
        </select>
        <button id="editable-table-add-button">Pievienot</button>
    </td>
</tr>

<div id="button-response"></div>

<script>
    var clickCount = <?php echo json_encode($rowCount); ?>;

    $(document).ready(function () {
        var selectTag = $('#editable-table-add-selection');

        $('#editable-table-add-button').click(function() {
            var formData = new FormData();

            var selectedValue = selectTag.val();
            var orderID = <?php echo json_encode($data['id']); ?>;
            var productsData = <?php echo json_encode($productsData); ?>;

            if(selectedValue == 'empty') {
                selectedValue = null;
            }
            clickCount++;

            formData.append("rowCount", JSON.stringify(clickCount));
            formData.append("id", JSON.stringify(selectedValue));
            formData.append("orderID", JSON.stringify(orderID));
            formData.append("productsData", JSON.stringify(productsData));
            $.ajax({
                url: '/veikals/admin/src/orders/editableTable/loadRowAJAX.php',
                method: 'POST',
                contentType: false,
                processData: false,
                data: formData,
                success: function(response) {
                    if(selectedValue != 'empty') {
                        console.log('work');
                        $("option[value='" + selectedValue + "']", selectTag).remove();
                    }
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