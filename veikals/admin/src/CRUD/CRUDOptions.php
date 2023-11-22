<?php

    class CRUDOptions {
        public static function load () {
            ?>
            <div class="option-container">
                <?php
                    CRUDOptions::loadNewButton();
                ?>
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