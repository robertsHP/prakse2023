<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/BasicFormTagLoader.php';

    function removePhoto (&$variableData) {
        echo 'fuck';
        $variableData['value'] = '';
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'removePhoto':
                    removePhoto($variableData);
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
        onchange="displayPhoto()"
    >
    <?php
        if(isset($variableData['value'])) {
            if($variableData['value'] != '') {
                ?>
                    <img 
                        src="<?php 
                            if(isset($variableData))
                                echo $variableData['value'];
                        ?>"
                        name = <?php echo $tagName.'-thumbnail'; ?>
                        id =<?php echo $tagName.'-thumbnail'; ?>
                        class="img-thumbnail img-product-photo" 
                    >

                    <input 
                        type="button" 
                        name="<?php echo $tagName.'-delete'; ?>" 
                        value="Noņemt bildi" 
                        class="btn btn-danger execution-button"
                        id="<?php echo $tagName.'-delete'; ?>" 
                    >
                <?php
            }
        }
    ?>
    <script>
        function displayPhoto () {
            var buttonID = "<?php echo $tagName.'-delete'; ?>";
            var imageID = "<?php echo $tagName.'-thumbnail'; ?>";

            console.log(buttonID);

            var button = document.getElementById(buttonID);
            var image = document.getElementById(imageID);

            var isVariableSet = <?php echo isset($variableData) ? 'true' : 'false'; ?>;

            console.log(isVariableSet);
            if(isVariableSet) {
                var isVariableEmpty = <?php echo isset($variableData['value']) ? 'true' : 'false'; ?>;
                console.log(isVariableEmpty);
                if (!isVariableEmpty) {
                    button.classList.remove('hidden');
                    image.classList.remove('hidden');
                    return;
                }
            }
            button.classList.add('hidden');
            image.classList.add('hidden');
        }

        $(document).ready(function() {
            var buttonID = "<?php echo '#'.$tagName.'-delete'; ?>";
            var imageID = "<?php echo '#'.$tagName.'-thumbnail'; ?>";
            // Attach a click event handler to the button
            $(buttonID).on("click", function() {
                // Send an AJAX POST request
                $.ajax({
                    url: window.location.href,
                    type: 'POST',
                    data: { action: 'hidePhoto' },
                    success: function(response) {
                        // Handle the successful response here
                        console.log(response);
                        $(imageID).hide();
                        $(buttonID).hide();
                    },
                    error: function(xhr, status, error) {
                        // Handle the error
                        console.error('Error: ' + status);
                    }
                });
            });
        });

        function openFileInput() {
            var fileInput = document.getElementById('file-input');
            fileInput.click();
        }

        function displaySelectedImage(input) {
            var fileInput = input;
            var selectedImage = document.getElementById('selected-image');

            if (fileInput.files && fileInput.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    selectedImage.src = e.target.result;
                };

                reader.readAsDataURL(fileInput.files[0]);
            }
        }
    </script>
</div>