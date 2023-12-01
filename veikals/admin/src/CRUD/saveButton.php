
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
        var rowIDArr = [];
        var orderID = null;

        function resetGlobalVariables () {
            checkPromises = [];
            savePromises = [];
            rowIDArr = [];
            orderID = null;
        }

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

        function callCheckDataPromise (formData, url) {
            var promise = $.ajax({
                type: 'POST',
                url: url,
                contentType: false,
                processData: false,
                data: formData,
            })
            .done(function(response) {
                console.log('check = '+response.success);
                setErrorMessages(response.data, response.rowNumber);
                $('#result').html(response);
            })
            .fail(function(error) {
                console.error("AJAX request failed:", error);
            });
            checkPromises.push(promise);
        }
        function getSaveAJAXRequest (formData, url) {
            return $.ajax({
                type: 'POST',
                url: url,
                contentType: false,
                processData: false,
                data: formData,
            })
            .done(function(response) {
                console.log('check = '+response.success);
                setErrorMessages(response.data, response.rowNumber);
                $('#result').html(response);
            })
            .fail(function(error) {
                console.error("AJAX request failed:", error);
            });
        }

        function callSaveDataPromise (formData, url) {
            var promise = getSaveAJAXRequest(formData, url);
            savePromises.push(promise);
        }
        function saveDataDirectCall (formData, url) {
            return getSaveAJAXRequest(formData, url);
        }
        function createFormDataWithResponse (response) {
            var formData = new FormData();
            for (var key in response) {
                var variable = response[key];
                formData.append(key, JSON.stringify(variable));
            }
            return formData;
        }
        function callEditableTableClear () {
            var formData = new FormData();
            formData.append('rowIDArr', JSON.stringify(rowIDArr));
            formData.append('orderID', JSON.stringify(orderID));

            var deleteCall = $.ajax({
                type: 'POST',
                url: '/veikals/admin/src/orders/editableTable/deleteEditableTableRows.php',
                contentType: false,
                processData: false,
                data: formData,
            })
            .done(function(response) {
                console.log('delete = '+response.success);
                $('#result').html(response);
            })
            .fail(function(error) {
                console.error("AJAX request failed:", error);
                resetGlobalVariables();
            });

            $.when(deleteCall).then(function () {
                resetGlobalVariables();
                // window.location.href = redirectPath;
            });
        }

        $('#save-button').click(function () {
            $('.input-form').each(function(index, form) {
                var formData = new FormData(form);
                formData.append('^data', JSON.stringify(data));
                callCheckDataPromise(formData, '/veikals/admin/src/CRUD/checkPageData.php');
                if($('.editable-table-row-form').length == 0) {
                    resetGlobalVariables();
                    callEditableTableClear();
                }
            });
            $('.editable-table-row-form').each(function() {
                var productsData = <?php echo json_encode($productsData); ?>;
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
                                var filteredID = idSplit[0];

                                var variable = tag.val();
                                if(tag.is(':file')) {
                                    variable = tag[0].files[0];
                                    if(typeof variable === 'undefined') {
                                        var img = $("#"+id).next();
                                        variable = img.attr('src');
                                    }
                                } else if (variable == "") {
                                    variable = $.trim(tag.text());
                                }
                                formData.append(filteredID, variable);
                            }
                        }
                    }
                });

                formData.append('^rowNumber', rowNumber);
                formData.append('^data', JSON.stringify(productsData));

                callCheckDataPromise(formData, '/veikals/admin/src/orders/editableTable/checkEditableTableData.php');
                rowNumber = null;
            });

            var success = true;

            Promise.all(checkPromises)
            .then(function(responses) {
                console.log('---CHECK---');
                $.each(responses, function(index, response) {
                    console.log(index+" = "+response.success);
                    if(!response.success) {
                        console.log('FAIL');
                        success = false;
                    }
                });
                console.log('Check success???? - '+success);
                if(success) {
                    var formData = createFormDataWithResponse(responses[0]);
                    formData.append('id', data['id']);
                    var ajaxCall = saveDataDirectCall(
                        formData, 
                        '/veikals/admin/src/CRUD/savePageData.php');

                    $.when(ajaxCall).done(function (data) {
                        $.each(responses, function(index, response) {
                            if (response.name == "editable-table") {
                                var purchaseData = response.data;
                                var purchGoodsData = <?php echo json_encode($purchGoodsData); ?>;
                                var formData = createFormDataWithResponse(response);

                                rowIDArr.push(purchaseData.id);
                                orderID = data.orderID;

                                formData.set('purchGoodsData', JSON.stringify(purchGoodsData));
                                formData.set('orderID', orderID);
                                formData.set('data', JSON.stringify(purchaseData));
                                callSaveDataPromise(
                                    formData, 
                                    '/veikals/admin/src/orders/editableTable/saveEditableTableData.php');
                            }
                        });
                        console.log('Check Successfull');
                        Promise.all(savePromises)
                        .then(function(responses) {
                            console.log('---SAVE---');
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
                                callEditableTableClear();
                            }
                        })
                        .catch(function(errors) {
                            console.log('At least one AJAX request failed');
                            console.log('Errors:', errors);
                            resetGlobalVariables();
                        });
                    }).fail(function (error) {
                        console.log('At least one AJAX request failed');
                        console.log('Errors:', errors);
                    });
                }
            })
            .catch(function(errors) {
                console.log('At least one AJAX request failed');
                console.log('Errors:', errors);
                resetGlobalVariables();
            });
        });
    });
</script>