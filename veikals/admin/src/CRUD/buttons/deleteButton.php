
<button
    type="button" 
    name="delete-button" 
    id="delete-button"
    class="btn btn-primary execution-button"
>Atpakaļ</button>
<script>
    $(document).ready(function () {
        var redirectPath = '/veikals/admin/src/orders/delete.php';
        $('#delete-button').click(function () {
            window.location.href = redirectPath;
        });
    });
</script>