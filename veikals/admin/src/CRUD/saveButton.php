
<button 
    type="submit" 
    name="save-button" 
    id="save-button"
    class="btn btn-primary execution-button"
>Saglabāt</button>

<div id="result"></div>

<script>
    var tableName = <?php echo json_encode($data['table-name']); ?>;

    $(document).ready(function () {
        var redirectPath = '/veikals/admin/src/'+tableName+'/index.php';
        
        $('#save-button').click(function () {
            var data = <?php echo json_encode($data); ?>;

            $('.input-form').each(function(index, form) {
                var formData = new FormData(form);
                formData.append('-data', JSON.stringify(data));

                $.ajax({
                    type: 'POST',
                    url: '/veikals/admin/src/CRUD/savePageData.php',
                    contentType: false,
                    processData: false,
                    // dataType: 'json',
                    data: formData,
                    success: function (response) {
                        // console.log(response);
                        if(response.success) {
                            window.location.href = redirectPath;
                        } else {
                            $.each(response.errorTags, function(index, value) {
                                if (value['error-message'] != null) {
                                    $("#"+index+"-alert").text(value['error-message']).show();
                                } else {
                                    $("#"+index+"-alert").hide();
                                }
                            });
                        }
                        $('#result').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error: ' + status + ' - ' + error);
                    }
                });
            });
        });
    });
</script>