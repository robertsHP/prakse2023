
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
        var data = <?php echo json_encode($data); ?>;
        var tableName = data['table-name'];
        var redirectPath = '/veikals/admin/src/'+tableName+'/index.php';

        var deferreds = [];

        function setErrorMessages (data, rowNumber) {
            if(data != null) {
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
            var deferred = $.Deferred();
            $.ajax({
                type: 'POST',
                url: '/veikals/admin/src/CRUD/savePageData.php',
                contentType: false,
                processData: false,
                data: formData,
            })
            .done(function(response) {
                setErrorMessages(response.data, response.rowNumber);
                $('#result').html(response);
                deferred.resolve(response);
            })
            .fail(function(error) {
                // Manually reject the deferred object
                deferred.reject(error);
            });
            return deferred.promise();
        }
        function saveEditableTableRow (formData) {
            var purchGoodsData = <?php echo json_encode($purchGoodsData); ?>;
            formData.append('^purchGoodsData', JSON.stringify(purchGoodsData));

            var deferred = $.Deferred();

            $.ajax({
                type: 'POST',
                url: '/veikals/admin/src/orders/editableTable/saveEditableTableData.php',
                contentType: false,
                processData: false,
                data: formData,
            })
            .done(function(response) {
                setErrorMessages(response.productsData, response.rowNumber);
                $('#result').html(response);
                deferred.resolve(response);
            })
            .fail(function(error) {
                // Manually reject the deferred object
                deferred.reject(error);
            });
            return deferred.promise();
        }

        $('#save-button').click(function () {
            deferreds = [];

            $('.input-form').each(function(index, form) {
                var formData = new FormData(form);
                formData.append('^data', JSON.stringify(data));
                deferreds.push(saveFormData(formData));
            });
            $('.editable-table-row-form').each(function() {
                var productsData = <?php echo json_encode($productsData); ?>;
                productsData['order_id'] = data['id'];
                productsData['db-process-type'] = data['db-process-type'];
            
                var formData = new FormData();
                var rowNumber = null;

                console.log('rownumber GOOO In = '+rowNumber);

                $(this).closest('tr').find('td').each(function () {
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
                rowNumber = null;
            });

            $.when.apply($, deferreds)
            .done(function() {
                var redirect = true;
                $.each(arguments, function(index, response) {
                    console.log(response.success);
                    if(!response.success) {
                        redirect = false;
                        return false;
                    }
                });
                // if(redirect)
                    // window.location.href = redirectPath;
            })
            .fail(function() {
                console.log('At least one AJAX request failed');

                var errors = Array.prototype.slice.call(arguments);
                console.log('Errors:', errors);
            });

        });
    });
</script>