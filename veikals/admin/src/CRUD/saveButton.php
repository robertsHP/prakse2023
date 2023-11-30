
<button 
    type="submit" 
    name="save-button" 
    id="save-button"
    class="btn btn-primary execution-button"
>Saglabāt</button>

<div id="result"></div>

<script>
    $(document).ready(function () {
        function saveFormData (formData) {
            var success = false;

            $.ajax({
                type: 'POST',
                url: '/veikals/admin/src/CRUD/savePageData.php',
                contentType: false,
                processData: false,
                data: formData,
                success: function (response) {
                    success = response.success;

                    if(response.errorTags !== null) {
                        $.each(response.errorTags, function(index, value) {
                            var tagStart = "#"+index;
                            if(response.rowNumber !== null) {
                                tagStart += response.rowNumber;
                            }
                            var alertTag = tagStart+"-alert";

                            if (value['error-message'] != null) {
                                $(alertTag).text(value['error-message']).show();
                            } else {
                                $(alertTag).hide();
                            }
                        });
                    }
                    $('#result').html(response);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + status + ' - ' + error);
                }
            });
            return success;
        }
        function saveEditableTableRow (formData) {
            var purchGoodsData = <?php echo json_encode($purchGoodsData); ?>;
            formData.append('^purchGoodsData', JSON.stringify(purchGoodsData));

            var success = false;

            $.ajax({
                type: 'POST',
                url: '/veikals/admin/src/orders/editableTable/saveEditableTableData.php',
                contentType: false,
                processData: false,
                data: formData,
                success: function (response) {
                    success = response.success;
                    $('#result').html(response);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + status + ' - ' + error);
                }
            });
            return success;
        }

        var tableName = <?php echo json_encode($data['table-name']); ?>;
        var redirectPath = '/veikals/admin/src/'+tableName+'/index.php';
        var data = <?php echo json_encode($data); ?>;

        $('#save-button').click(function () {
            $('.input-form').each(function(index, form) {
                var formData = new FormData(form);
                formData.append('^data', JSON.stringify(data));
                success = saveFormData(formData);
                // if(success) {
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
                        success = saveFormData(formData);
                        // if(success) {
                            success = saveEditableTableRow(formData);
                        // }
                    });
                // }
            });
        });
    });
</script>