<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormErrorType.php';

    class TagLoader {
        public static function loadButton ($type, $name, $value, $class) {
            ?>
                <input 
                    type="<?php echo $type; ?>" 
                    name="<?php echo $name; ?>" 
                    value="<?php echo $value; ?>" 
                    class="<?php echo $class; ?>">
            <?php
        }
        public static function loadButtonRow ($pageData) {
            if(isset($pageData['buttons'])) {
                foreach ($pageData['buttons'] as $buttonInfo) {
                    TagLoader::loadButton(
                        $buttonInfo['type'],
                        $buttonInfo['name'],
                        $buttonInfo['value'],
                        $buttonInfo['class']
                    );
                }
            }
        }
        public static function loadAlert ($tagName) {
            $finalTagName = $tagName.'-alert';
            ?>
                <div id="<?php echo $finalTagName; ?>" class="alert alert-danger"></div>
            <?php
            return $finalTagName;
        }
        public static function loadInputErrorMessage ($tagName, $variableData) {
            $finalTagName = null;
            if(isset($variableData)) {
                if(array_key_exists('required', $variableData)) {
                    if($variableData['required']) {
                        $finalTagName = TagLoader::loadAlert($tagName);
                    }
                }
            }
            return $finalTagName;
        }
        public static function loadLabel ($title, $fieldName, $variableData) {
            ?>
                <label for=<?php echo $fieldName; ?>>
                    <?php 
                        echo $title; 
                        if(isset($variableData)) {
                            if(array_key_exists('required', $variableData)) {
                                if($variableData['required']) {
                                    ?> <span class="required-star">*</span> <?php
                                }
                            }
                        }
                    ?>
                </label>
            <?php
        }
    }
?>