<script>
    var errorTags = <?php echo json_encode($data['error-tags']); ?>

    $(document).ready(function () {
        $.each(errorTags, function(index, value) {
            $("#"+index+"-alert").hide();
        });
    });
</script>