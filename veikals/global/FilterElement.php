<?php
    class FilterElement {
        public static function load () {

        }
        private static function outputFilterSelect ($tableName) {
            ?>
                <select name="cars" id="cars">
                    
                    <option value="volvo">Volvo</option>
                    <option value="saab">Saab</option>
                    <option value="opel">Opel</option>
                    <option value="audi">Audi</option>
                </select>
            <?php
        }
    }

?>