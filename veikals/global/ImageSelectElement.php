<?php
    class ImageSelectElement {
        public static function load (string $tagName, $elementValue, array $allowedFileFormats) {
            $thumbNailTagName = $tagName.'-image-sel';
            $deleteButtonTagName = $tagName.'-delete';
            $allowedFileFormatsStr = implode(', ', $allowedFileFormats);

            ImageSelectElement::loadRequestProcessing($tagName);
            ImageSelectElement::loadFileSelect($elementValue, $tagName, $allowedFileFormatsStr);
            ImageSelectElement::loadImage($elementValue, $thumbNailTagName);
            ImageSelectElement::loadDeleteButton($deleteButtonTagName);

            ?> 
                <script src="/veikals/assets/js/imageSelectElement.js"></script>
                <script>
                    var fileInputID = <?php echo json_encode($tagName); ?>;
                    var deleteButtonID = <?php echo json_encode($deleteButtonTagName); ?>;
                    var selectedImageID = <?php echo json_encode($thumbNailTagName); ?>;

                    var elementValue = <?php echo json_encode($elementValue); ?>;

                    initDeleteButton('#'+fileInputID, '#'+selectedImageID, '#'+deleteButtonID);
                    initFileInput('#'+fileInputID, '#'+selectedImageID, '#'+deleteButtonID);
                    initImageSelect(elementValue, '#'+fileInputID, '#'+selectedImageID, '#'+deleteButtonID);

                    document.getElementById(selectedImageID).onclick = function () {
                        var fileInput = document.getElementById(fileInputID);
                        fileInput.click();
                    }
                </script> 
            <?php
        }
        private static function loadRequestProcessing (string $tagName) {
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
        }
        private static function loadFileSelect ($elementValue, string $tagName, string $allowedFileFormatsStr) {
            ?>
                <input 
                    type="file"  
                    class="form-control-file" 
                    name="<?php echo $tagName; ?>"
                    id="<?php echo $tagName; ?>"
                    accept="<?php echo $allowedFileFormatsStr; ?>"
                    value="<?php 
                        if(isset($elementValue))
                            echo $elementValue;
                    ?>"
                >
            <?php
        }
        private static function loadImage ($elementValue, $thumbNailTagName) {
            ?>
                <img 
                    src="<?php 
                        if(isset($elementValue))
                            echo $elementValue;
                    ?>"
                    name = "<?php echo $thumbNailTagName; ?>"
                    id ="<?php echo $thumbNailTagName; ?>"
                    class="img-thumbnail img-product-photo" 
                >
            <?php
        }
        private static function loadDeleteButton ($deleteButtonTagName) {
            ?>
                <input 
                    type="button" 
                    name="<?php echo $deleteButtonTagName; ?>" 
                    value="Noņemt bildi" 
                    class="btn btn-danger execution-button"
                    id="<?php echo $deleteButtonTagName; ?>" 
                >
            <?php
        }
    }
?>