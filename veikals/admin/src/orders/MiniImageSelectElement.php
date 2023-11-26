<?php
    class MiniImageSelectElement {
        public static function load (string $tagName, $elementValue, array $allowedFileFormats) {
            $thumbNailTagName = $tagName.'-thumbnail';
            $allowedFileFormatsStr = implode(', ', $allowedFileFormats);

            MiniImageSelectElement::loadRequestProcessing($tagName);
            MiniImageSelectElement::loadFileSelect($elementValue, $tagName, $allowedFileFormatsStr);
            MiniImageSelectElement::loadImage($elementValue, $thumbNailTagName);

            ?> 
                <script src="/veikals/assets/js/imageSelectElement.js"></script>
                <script>
                    var fileInputID = <?php echo json_encode($tagName); ?>;
                    var selectedImageID = <?php echo json_encode($thumbNailTagName); ?>;

                    var elementValue = <?php echo json_encode($elementValue); ?>;

                    initFileInput('#'+fileInputID, '#'+selectedImageID, null);
                    initImageSelect(elementValue, '#'+fileInputID, '#'+selectedImageID, null);

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
                    accept="<?php echo $allowedFileFormats; ?>"
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
                    width="100"
                    name = <?php echo $thumbNailTagName; ?>
                    id ="<?php echo $thumbNailTagName; ?>"
                >
            <?php
        }
    }
?>