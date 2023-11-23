<?php
    class SearchElement {
        public static function load () {
            SearchElement::loadSearchTag();
            SearchElement::loadSearchScript();
        }
        private static function loadSearchTag () {
            ?>
                <div class="search-container">
                    <input 
                        type="text" 
                        class="form-control search-input"
                        id="search-input" 
                        name=""
                        placeholder="Meklēt..."
                        value=""
                    >
                    <i class="fas fa-search search-icon"></i>
                </div>
            <?php
        }
        private static function loadSearchScript () {
            ?>
                <script>
                    $(document).ready(function(){
                        var $searchInput = $('#search-input');
                        var $tableRows = $('table tbody tr');

                        $searchInput.on('keyup', function() {
                            var searchTerm = $(this).val().toLowerCase();

                            $tableRows.each(function() {
                                var textToSearch = $(this).text().toLowerCase();
                                var isVisible = textToSearch.includes(searchTerm);

                                $(this).toggle(isVisible);
                            });
                        });
                    });
                </script>
            <?php
        }
    }
?>