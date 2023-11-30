
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
            $.ajax({
                type: 'POST',
                url: '/veikals/admin/src/CRUD/savePageData.php',
                contentType: false,
                processData: false,
                data: formData,
                success: function (response) {
                    if(response.success) {
                        window.location.href = redirectPath;
                    } else {
                        if(response.errorTags) {
                            $.each(response.errorTags, function(index, value) {
                                if (value['error-message'] != null) {
                                    $("#"+index+"-alert").text(value['error-message']).show();
                                } else {
                                    $("#"+index+"-alert").hide();
                                }
                            });
                        }
                    }
                    $('#result').html(response);
                },
                error: function(xhr, status, error) {
                    console.error(xhr);
                    console.error('AJAX Error: ' + status + ' - ' + error);
                }
            });
        }
        function saveEditableTableRow (formData) {
            var purchGoodsData = <?php echo json_encode($purchGoodsData); ?>;
            formData.append('-purchGoodsData', JSON.stringify(purchGoodsData));

            $.ajax({
                type: 'POST',
                url: '/veikals/admin/src/orders/editableTable/saveEditableTableData.php',
                contentType: false,
                processData: false,
                data: formData,
                success: function (response) {
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
            $('.input-form').each(function(index, form) {
                var formData = new FormData(form);
                formData.append('-data', JSON.stringify(data));
                saveFormData(formData);
            });
            $('.editable-table-row-form').each(function(index, form) {
                var productsData = <?php echo json_encode($productsData); ?>;
                productsData['order_id'] = data['id'];
            
                var formData = new FormData();

                $("td").each(function () {
                    //Paņem pirmo tag, kas pieejams
                    var tag = $(this).find(':first-child');
                    var tagName = tag.prop("tagName");

                    if(typeof tagName !== 'undefined') {
                        tagName = tagName.toLowerCase();
                        if(tagName !== 'button') {
                            var id = tag.attr('id');
                            if (typeof id !== 'undefined') {
                                id = id.split(/\d/)[0];
                                console.log(id);
                                formData.append(id, tag.val());
                            }
                        }
                    }
                });
                formData.append('-data', JSON.stringify(productsData));
                saveFormData(formData);
                saveEditableTableRow(formData);
            });
        });
    });
</script>