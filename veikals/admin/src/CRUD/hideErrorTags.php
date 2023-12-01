<script>
    var errorTags = <?php echo json_encode($data['form-data']); ?>

    $(document).ready(function () {
        $.each(errorTags, function(index, value) {
            $("#"+index+"-alert").hide();
        });
    });
</script>