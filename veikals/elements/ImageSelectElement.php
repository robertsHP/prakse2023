<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/BasicFormTagLoader.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/FileUpload.php';

    class ImageSelectElement {
        function __construct(string $title, string $tagName, array $allowedFileFormats) {
            $this->title = $title;
            $this->tagName = $tagName;
            $this->thumbNailTagName = $tagName.'-thumbnail';
            $this->deleteButtonTagName = $tagName.'-delete';
            $this->allowedFileFormats = implode(', ', $allowedFileFormats);
            $this->errorConditions =  FormTypeErrorConditions::FILE_DEFAULT;
        }
        public function load ($elementValue) {
            $this->loadRequestProcessing();
            $this->loadFileSelect($elementValue);
            $this->loadImage($elementValue);
            $this->loadDeleteButton();

            ?> 
                <script src="/veikals/assets/elements/imageSelectElement.js"></script>
                <script>
                    var fileInputID = <?php echo json_encode($this->tagName); ?>;
                    var deleteButtonID = <?php echo json_encode($this->deleteButtonTagName); ?>;
                    var selectedImageID = <?php echo json_encode($this->thumbNailTagName); ?>;

                    var elementValue = <?php echo json_encode($elementValue); ?>;

                    initAJAX('#'+fileInputID, '#'+selectedImageID, '#'+deleteButtonID);
                    initImageSelect(elementValue, '#'+fileInputID, '#'+selectedImageID, '#'+deleteButtonID);

                    document.getElementById(selectedImageID).onclick = function () {
                        var fileInput = document.getElementById(fileInputID);
                        fileInput.click();
                    }
                </script> 
            <?php
        }
        private function loadRequestProcessing () {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['action'])) {
                    switch ($_POST['action']) {
                        case 'removePhotoPath':
                            $_SESSION['temp']['paths'][$this->tagName] = '';
                            break;
                        case 'updatePhotoPath':
                            $_SESSION['temp']['paths'][$this->tagName] = $_POST['imageData'];
                            break;
                    }
                }
            }
        }
        private function loadFileSelect ($elementValue) {
            ?>
                <input 
                    type="file"  
                    class="form-control-file" 
                    name="<?php echo $this->tagName; ?>"
                    id="<?php echo $this->tagName; ?>"
                    accept="<?php echo $this->allowedFileTypes; ?>"
                    value="<?php 
                        if(isset($elementValue))
                            echo $elementValue;
                    ?>"
                >
            <?php
        }
        private function loadImage ($elementValue) {
            ?>
                <img 
                    src="<?php 
                        if(isset($elementValue))
                            echo $elementValue;
                    ?>"
                    name = <?php echo $this->thumbNailTagName; ?>
                    id ="<?php echo $this->thumbNailTagName; ?>"
                    class="img-thumbnail img-product-photo" 
                >
            <?php
        }
        private function loadDeleteButton () {
            ?>
                <input 
                    type="button" 
                    name="<?php echo $this->deleteButtonTagName; ?>" 
                    value="Noņemt bildi" 
                    class="btn btn-danger execution-button"
                    id="<?php echo $this->deleteButtonTagName; ?>" 
                >
            <?php
        }
    }
?>