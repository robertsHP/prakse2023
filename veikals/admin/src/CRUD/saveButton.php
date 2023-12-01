
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

        var checkPromises = [];
        var savePromises = [];

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
        function checkFormData (formData) {
            var promise = $.ajax({
                type: 'POST',
                url: '/veikals/admin/src/CRUD/checkPageData.php',
                contentType: false,
                processData: false,
                data: formData,
            })
            .done(function(response) {
                console.log('form check = '+response.success);
                setErrorMessages(response.data, response.rowNumber);
                $('#result').html(response);

                if(response.success) {
                    formData.set('^data', JSON.stringify(response.data));
                    saveFormData(formData);
                }
            })
            .fail(function(error) {
                
            });
            checkPromises.push(promise);
        }
        function saveFormData (formData) {
            var promise = $.ajax({
                type: 'POST',
                url: '/veikals/admin/src/CRUD/savePageData.php',
                contentType: false,
                processData: false,
                data: formData,
            })
            .done(function(response) {
                $('#result').html(response);
                console.log('form save = '+response.success);
            })
            .fail(function(error) {
                
            });
            savePromises.push(promise);
        }
        function checkEditableTableRow (formData) {
            var promise = $.ajax({
                type: 'POST',
                url: '/veikals/admin/src/orders/editableTable/checkEditableTableData.php',
                contentType: false,
                processData: false,
                data: formData,
            })
            .done(function(response) {
                console.log('editable check = '+response.success);
                setErrorMessages(response.productsData, response.rowNumber);
                $('#result').html(response);

                if(response.success) {
                    var purchGoodsData = <?php echo json_encode($purchGoodsData); ?>;

                    formData.set('^data', JSON.stringify(response.productsData));
                    formData.set('^purchGoodsData', JSON.stringify(purchGoodsData));

                    saveEditableTableRow(formData);
                }
            })
            .fail(function(error) {
                // Manually reject the deferred object
            });
            checkPromises.push(promise);
        }
        function saveEditableTableRow (formData) {
            var promise = $.ajax({
                type: 'POST',
                url: '/veikals/admin/src/orders/editableTable/saveEditableTableData.php',
                contentType: false,
                processData: false,
                data: formData,
            })
            .done(function(response) {
                console.log('editable save = '+response.success);
            })
            .fail(function(error) {
                // Manually reject the deferred object
            });
            savePromises.push(promise);
        }

        $('#save-button').click(function () {
            checkPromises = [];
            savePromises = [];

            $('.input-form').each(function(index, form) {
                var formData = new FormData(form);
                formData.append('^data', JSON.stringify(data));
                checkFormData(formData);
            });
            $('.editable-table-row-form').each(function() {
                var productsData = <?php echo json_encode($productsData); ?>;
                productsData['order_id'] = data['id'];
                productsData['db-process-type'] = data['db-process-type'];
            
                var formData = new FormData();
                var rowNumber = null;

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

                checkEditableTableRow(formData);
                rowNumber = null;
            });

            Promise.all(checkPromises)
            .then(function(responses) {
                console.log('---CHECK---');
                var success = true;
                $.each(responses, function(index, response) {
                    console.log(index+" = "+response.success);
                    if(!response.success) {
                        console.log('FAIL');
                        success = false;
                        return false;
                    }
                });
                console.log('Check success???? - '+success);
                if(success) {
                    console.log('Check Successfull');
                    Promise.all(savePromises)
                    .then(function(responses) {
                        console.log('---SAVE---');
                        var success = true;
                        $.each(responses, function(index, response) {
                            console.log(index+" = "+response.success);
                            if(!response.success) {
                                console.log('FAIL');
                                success = false;
                                return false;
                            }
                        });
                        console.log('Save success???? - '+success);
                        if(success) {
                            window.location.href = redirectPath;
                        }
                    })
                    .catch(function(errors) {
                        console.log('At least one AJAX request failed');
                        console.log('Errors:', errors);
                    });
                }
            })
            .catch(function(errors) {
                console.log('At least one AJAX request failed');
                console.log('Errors:', errors);
            });
        });
    });
</script>