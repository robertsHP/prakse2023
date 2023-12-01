
<button
    type="button" 
    name="delete-button" 
    id="delete-button"
    class="btn btn-danger execution-button"
>Dzēst</button>
<script>
    var tableName = <?php echo json_encode($data['table-name']); ?>;
    var id = <?php echo json_encode($data['id']); ?>;

    $(document).ready(function () {
        var redirectPath = '/veikals/admin/src/'+tableName+'/delete.php?id='+id;
        $('#delete-button').click(function () {
            window.location.href = redirectPath;
        });
    });
</script>