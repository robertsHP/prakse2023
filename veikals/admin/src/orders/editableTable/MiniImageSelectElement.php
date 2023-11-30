
<?php
    $dataKeys = array_keys($data['form-data']);

    $allowedFileFormats = $data['form-data'][$dataKeys[2]]['allowed_file_formats'];
    $allowedFileFormatsStr = implode(', ', $allowedFileFormats);

    $inputTagName = $tagName.'-image-input';
    $imageTagName = $tagName.'-image';
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
        var fileInputID = <?php echo json_encode($inputTagName); ?>;
        var selectedImageID = <?php echo json_encode($imageTagName); ?>;
        var elementValue = <?php echo json_encode($elementValue); ?>

        initFileInput('#'+fileInputID, '#'+selectedImageID, null);
        initImageSelect(elementValue, '#'+fileInputID, '#'+selectedImageID, null);

        $('#'+selectedImageID).click(function(){
            var fileInputID = <?php echo json_encode($inputTagName); ?>;
            var fileInput = document.getElementById(fileInputID);
            fileInput.click();
        });
    });
</script> 