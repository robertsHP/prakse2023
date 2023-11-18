<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/BasicFormTagLoader.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/FileUpload.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'removePhotoPath':
                    $_SESSION['temp']['paths'][$tagName] = '';
                    break;
                case 'updatePhotoPath':
                    $_SESSION['temp']['paths'][$tagName] = $_POST['imageData'];
                    break;
            }
        }
    }
?>
<div class="mb-3">
    <input 
        type="file"  
        class="form-control-file" 
        name="<?php echo $tagName; ?>"
        id="<?php echo $tagName; ?>"
        accept="<?php echo $allowedFileTypes; ?>"
        value="<?php 
            if(isset($variableData))
                echo $variableData['value'];
        ?>"
    >
    <img 
        src="<?php 
            if(isset($variableData))
                echo $variableData['value'];
        ?>"
        name = <?php echo $tagName.'-thumbnail'; ?>
        id ="<?php echo $tagName.'-thumbnail'; ?>"
        class="img-thumbnail img-product-photo" 
        onclick="openFileInput()"
    >
    <input 
        type="button" 
        name="<?php echo $tagName.'-delete'; ?>" 
        value="Noņemt bildi" 
        class="btn btn-danger execution-button"
        id="<?php echo $tagName.'-delete'; ?>" 
    >
    <script>
        $(document).ready(function() {
            var fileInputID = "<?php echo '#'.$tagName; ?>";
            var deleteButtonID = "<?php echo '#'.$tagName.'-delete'; ?>";
            var selectedImageID = "<?php echo '#'.$tagName.'-thumbnail'; ?>";
            // Attach a click event handler to the button
            $(deleteButtonID).on("click", function() {
                // Send an AJAX POST request
                $.ajax({
                    url: window.location.href,
                    type: 'POST',
                    data: { action: 'removePhotoPath' },
                    success: function(response) {
                        // Handle the successful response here
                        // console.log(response);
                        $(fileInputID).show();
                        $(selectedImageID).hide();
                        $(deleteButtonID).hide();
                    },
                    error: function(xhr, status, error) {
                        // Handle the error
                        console.error('Error: ' + status);
                    }
                });
            });
            $(fileInputID).change(function() {
                var fileInput = this;

                if (fileInput.files && fileInput.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $(selectedImageID).attr('src', e.target.result)

                        $.ajax({
                            url: window.location.href,
                            type: 'POST',
                            data: { 
                                action: 'updatePhotoPath', 
                                imageData: fileInput.files[0].name 
                            },
                            success: function(response) {
                                // Handle the successful response here
                                // console.log(response);
                                console.log(fileInput.files[0].name);
                                $(fileInputID).hide();
                                $(selectedImageID).show();
                                $(deleteButtonID).show();
                            },
                            error: function(xhr, status, error) {
                                // Handle the error
                                console.error('Error: ' + status);
                            }
                        });
                    };

                    reader.readAsDataURL(fileInput.files[0]);
                }
            });
        });

        function openFileInput() {
            var fileInput = document.getElementById("<?php echo $tagName; ?>");
            fileInput.click();
        }

        function initImageSelect () {
            var fileInputID = "<?php echo "#".$tagName; ?>";
            var selectedImageID = "<?php echo "#".$tagName.'-thumbnail'; ?>";
            var deleteButtonID = "<?php echo "#".$tagName.'-delete'; ?>";

            var variableData = "<?php echo $variableData['value']; ?>"

            $(selectedImageID).on('mouseover', function () {
                $(this).css('cursor', 'pointer');
            });
            $(selectedImageID).on('mouseout', function () {
                $(this).css('cursor', 'default');
            });

            if(variableData != '') {
                $(fileInputID).hide();
                $(selectedImageID).show();
                $(deleteButtonID).show();
            } else {
                $(fileInputID).show();
                $(selectedImageID).hide();
                $(deleteButtonID).hide();
            }
        }
        initImageSelect();
    </script>
</div>