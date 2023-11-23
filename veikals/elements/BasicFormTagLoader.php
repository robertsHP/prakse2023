<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/elements/enums/FormErrorType.php';

    class BasicFormTagLoader {
        public static function loadButton ($type, $name, $value, $class) {
            ?>
                <input 
                    type="<?php echo $type; ?>" 
                    name="<?php echo $name; ?>" 
                    value="<?php echo $value; ?>" 
                    class="<?php echo $class; ?>">
            <?php
        }
        public static function loadAlert ($strMsg) {
            ?>
                <div class="alert alert-danger">
                    <?php echo $strMsg; ?>
                </div>
            <?php
        }
        public static function loadButtonRow ($pageData) {
            if(isset($pageData['buttons'])) {
                foreach ($pageData['buttons'] as $buttonInfo) {
                    BasicFormTagLoader::loadButton(
                        $buttonInfo['type'],
                        $buttonInfo['name'],
                        $buttonInfo['value'],
                        $buttonInfo['class']
                    );
                }
            }
        }
        public static function loadErrorMessage ($variableData, $errorConditions) {
            if(isset($variableData)) {
                if($variableData['required']) {
                    if($variableData['errorType'] != FormErrorType::NONE) {
                        $errorCases = FormErrorType::cases();
                        for ($i = 1; $i < count($errorCases); $i++) {
                            $case = $errorCases[$i];
                            if($variableData['errorType'] == $case) {
                                BasicFormTagLoader::loadAlert($errorConditions[$case->value]);
                            }
                        }
                    }
                }
            }
        }
        public static function loadLabel ($title, $fieldName, $variableData) {
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