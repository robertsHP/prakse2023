
<button
    type="button" 
    name="back-button" 
    id="back-button"
    class="btn btn-primary execution-button"
>Atpakaļ</button>
<script>
    var tableName = <?php echo json_encode($data['table-name']); ?>;

    $(document).ready(function () {
        var redirectPath = '/veikals/admin/src/'+tableName+'/index.php';
        $('#back-button').click(function () {
            window.location.href = redirectPath;
        });
    });
</script>