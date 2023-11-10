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
        public static function errorMessage ($variableData, $errorMessages) {
            if(isset($variableData)) {
                if($variableData['required']) {
                    if(isset($variableData['errorType'])) {
                        if($variableData['errorType'] == 'empty') {
                            FormElement::alert($errorMessages['empty']);
                        }
                    }
                }
            }
        }
        public static function label ($title, $fieldName, $variableData) {
            ?>
                <label for=<?php echo $fieldName; ?>>
                    <?php 
                        echo $title; 
                        if(isset($variableData)) {
                            if($variableData['required']) {
                                ?> <span class="required-star">*</span> <?php
                            }
                        }
                    ?>
                </label>
            <?php
        }
    }
?>