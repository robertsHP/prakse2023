<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/elements/SearchElement.php';

    class CRUDOptions {
        public static function load () {
            ?>
            <div class="option-container">
                <div class="element"> <?php CRUDOptions::loadNewButton(); ?> </div>
                <div class="element"> <?php SearchElement::load(); ?> </div>
            </div>
            <?php
        }
        private static function loadNewButton () {
        
            ?>
                <a class="link-button" href="create.php">
                    <button type="button" class="btn btn-primary">
                        Pievienot jaunu
                    </button>
                </a>
            <?php
        }
    }
?>