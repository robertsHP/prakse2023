<?php
    class FormElement {
        public static function button ($type, $name, $value, $class) {
            ?>
                <input 
                    type="<?php echo $type; ?>" 
                    name="<?php echo $name; ?>" 
                    value="<?php echo $value; ?>" 
                    class="<?php echo $class; ?>">
            <?php
        }
        public static function alert ($strMsg) {
            ?>
                <div class="alert alert-danger">
                    <?php echo $strMsg; ?>
                </div>
            <?php
        }
        public static function buttonRow ($pageData) {
            if(isset($pageData['buttons'])) {
                foreach ($pageData['buttons'] as $buttonInfo) {
                    FormElement::button(
                        $buttonInfo['type'],
                        $buttonInfo['name'],
                        $buttonInfo['value'],
                        $buttonInfo['class']
                    );
                }
            }
        }
        public static function input ($dataArray) {
            ?>
                <div class="form-group">
                    <label for=<?php echo $dataArray['name']; ?>>
                        <?php 
                            echo $dataArray['title']; 
                            if($dataArray['required']) {
                                ?> <span class="required-star">*</span> <?php
                            }
                        ?>
                    </label>
                    <input 
                        type="<?php echo $dataArray['type']; ?>"  
                        class="form-control" 
                        name="<?php echo $dataArray['name']; ?>"
                        id="<?php echo $dataArray['name']; ?>"
                        placeholder="<?php echo $dataArray['placeholder']; ?>"
                        value="<?php 
                            if(isset($dataArray['variable']))
                                echo $dataArray['variable']['value'];
                        ?>">
                    <?php
                        if($dataArray['required']) {
                            if(isset($dataArray['variable'])) {
                                foreach ($dataArray['errorCheck'] as $errorCheck) {
                                    if($errorCheck[1]) {
                                        FormElement::alert($errorCheck[0]);
                                    }
                                }
                            }
                        }
                    ?>
                </div>
            <?php
        }
    }
?>