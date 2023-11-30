
<button 
    type="submit" 
    name="save-button" 
    id="save-button"
    class="btn btn-primary execution-button"
>Saglabāt</button>

<div id="result"></div>

<?php
    $productsData = isset($productsData) ? $productsData : null;
    $purchGoodsData = isset($purchGoodsData) ? $purchGoodsData : null;
?>

<script>
    $(document).ready(function () {
        function setErrorMessages (data, rowNumber) {
            if(data['form-data'] !== null) {
                $.each(data['form-data'], function(index, value) {
                    var tagStart = "#"+index;
                    if(rowNumber !== null) {
                        tagStart += rowNumber;
                    }
                    var alertTag = tagStart+"-alert";

                    if (value['error-message'] != null) {
                        $(alertTag).text(value['error-message']).show();
                    } else {
                        $(alertTag).hide();
                    }
                });
            }
        }
        function saveFormData (formData) {
            $.ajax({
                type: 'POST',
                url: '/veikals/admin/src/CRUD/savePageData.php',
                contentType: false,
                processData: false,
                data: formData,
                success: function (response) {
                    success = response.success;
                    console.log("horraayy ordinary = "+success);
                    setErrorMessages(response.data, response.rowNumber);
                    $('#result').html(response);
                    if(success)
                        window.location.href = redirectPath;
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + status + ' - ' + error);
                }
            });
        }
        function saveEditableTableRow (formData) {
            var purchGoodsData = <?php echo json_encode($purchGoodsData); ?>;
            formData.append('^purchGoodsData', JSON.stringify(purchGoodsData));

            $.ajax({
                type: 'POST',
                url: '/veikals/admin/src/orders/editableTable/saveEditableTableData.php',
                contentType: false,
                processData: false,
                data: formData,
                success: function (response) {
                    success = response.success;
                    // console.log("succ inside = "+success);
                    setErrorMessages(response.productsData, response.rowNumber);
                    $('#result').html(response);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + status + ' - ' + error);
                }
            });
        }

        var tableName = <?php echo json_encode($data['table-name']); ?>;
        var redirectPath = '/veikals/admin/src/'+tableName+'/index.php';
        var data = <?php echo json_encode($data); ?>;

        $('#save-button').click(function () {
            $('.editable-table-row-form').each(function(index, form) {
                var productsData = <?php echo json_encode($productsData); ?>;
                productsData['order_id'] = data['id'];
            
                var formData = new FormData();
                var rowNumber = null;

                $("td").each(function () {
                    //Paņem pirmo tag, kas pieejams
                    var tag = $(this).find(':first-child');
                    var tagType = tag.prop("tagName");

                    if(typeof tagType !== 'undefined') {
                        tagType = tagType.toLowerCase();
                        if(tagType !== 'button') {
                            var id = tag.attr('id');
                            if (typeof id !== 'undefined') {
                                idSplit = id.split(/(\d+)/);
                                if(rowNumber == null) {
                                    rowNumber = idSplit[1];
                                }
                                id = idSplit[0];

                                var variable = null;
                                if(tag.is(':file')) {
                                    variable = tag[0].files[0];
                                } else {
                                    variable = tag.val();
                                }
                                formData.append(id, variable);
                            }
                        }
                    }
                });
                formData.append('^rowNumber', rowNumber);
                formData.append('^data', JSON.stringify(productsData));
                saveEditableTableRow(formData);
            });
            $('.input-form').each(function(index, form) {
                var formData = new FormData(form);
                formData.append('^data', JSON.stringify(data));
                saveFormData(formData);
            });
        });
    });
</script>