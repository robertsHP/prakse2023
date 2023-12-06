
<?php
    $allowedFileFormats = $productsData['form-data'][$productsKeys[2]]['allowed_file_formats'];
    $allowedFileFormatsStr = implode(', ', $allowedFileFormats);

    $inputTagName = $tagName.'-image-input';
    $imageTagName = $tagName.'-image';
?>
    <input 
        <?php echo $editable ? '' : 'disabled' ?>
        type="file"  
        class="form-control-file" 
        name="<?php echo $inputTagName; ?>"
        id="<?php echo $inputTagName; ?>"
        accept="<?php echo $allowedFileFormatsStr; ?>"
        value="<?php 
            if(isset($variableData))
                echo $variableData['value'];
        ?>"
    >
    <img 
        <?php echo $editable ? '' : 'disabled' ?>
        src="<?php 
            if(isset($variableData))
                echo $variableData['value'];
        ?>"
        width="100"
        name="<?php echo $imageTagName; ?>"
        id="<?php echo $imageTagName; ?>"
    >

<?php
    // setTagState($inputTagName, $editable);
    // setTagState($imageTagName, $editable);
?>
<script>
    //Bildes izvēlei
    $.getScript('/veikals/assets/js/imageSelectElement.js', function() {
        var fileInputID = <?php echo json_encode($inputTagName); ?>;
        var selectedImageID = <?php echo json_encode($imageTagName); ?>;
        var value = <?php echo json_encode($variableData['value']); ?>

        initFileInput('#'+fileInputID, '#'+selectedImageID, null);
        initImageSelect(value, '#'+fileInputID, '#'+selectedImageID, null);

        $('#'+selectedImageID).click(function(){
            var fileInputID = <?php echo json_encode($inputTagName); ?>;
            var fileInput = document.getElementById(fileInputID);
            fileInput.click();
        });
    });
</script> 