
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
            $('.input-form').each(function() {
                var tempFormData = $(this).serializeArray();
                $.ajax({
                    type: 'POST',
                    url: '/veikals/admin/src/CRUD/savePageData.php',
                    // dataType: 'json',
                    data: {
                        tempFormData: tempFormData,
                        data: data
                    },
                    success: function (response) {
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