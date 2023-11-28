
<button
    type="button" 
    name="back-button" 
    id="back-button"
    class="btn btn-primary execution-button"
>Atpakaļ</button>
<script>
    $(document).ready(function () {
        var redirectPath = '/veikals/admin/src/orders/index.php';
        $('#back-button').click(function () {
            window.location.href = redirectPath;
        });
    });
</script>