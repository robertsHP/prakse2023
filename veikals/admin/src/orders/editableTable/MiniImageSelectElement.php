
<?php
    $productsDataKeys = array_keys($productsData['form-data']);

    $allowedFileFormats = $productsData['form-data'][$productsDataKeys[2]]['allowed_file_formats'];
    $allowedFileFormatsStr = implode(', ', $allowedFileFormats);

    $inputTagName = 'editable-table-row-image-input-'.$rowCount;
    $imageTagName = 'editable-table-row-image-'.$rowCount;
?>
    <input 
        type="file"  
        class="form-control-file" 
        name="<?php echo $inputTagName; ?>"
        id="<?php echo $inputTagName; ?>"
        accept="<?php echo $allowedFileFormats; ?>"
        value="<?php 
            if(isset($elementValue))
                echo $elementValue;
        ?>"
    >
    <img 
        src="<?php 
            if(isset($elementValue))
                echo $elementValue;
        ?>"
        width="100"
        name="<?php echo $imageTagName; ?>"
        id="<?php echo $imageTagName; ?>"
    >
<script>
    //Bildes izvēlei
    $.getScript('/veikals/assets/js/imageSelectElement.js', function() {
        var clickCount = <?php echo json_encode($rowCount); ?>;

        var fileInputID = 'editable-table-row-image-input-'+clickCount;
        var selectedImageID = 'editable-table-row-image-'+clickCount;
        var elementValue = <?php echo json_encode($elementValue); ?>

        initFileInput('#'+fileInputID, '#'+selectedImageID, null);
        initImageSelect(elementValue, '#'+fileInputID, '#'+selectedImageID, null);

        $('#'+selectedImageID).click(function(){
            var clickCount = <?php echo json_encode($rowCount); ?>;
            var fileInputID = 'editable-table-row-image-input-'+clickCount;
            var fileInput = document.getElementById(fileInputID);
            fileInput.click();
        });
    });
</script> 