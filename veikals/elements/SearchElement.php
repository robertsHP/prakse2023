<?php
    class SearchElement {
        public static function load () {
            SeachElement::loadSearchTag();
            SeachElement::loadSearchScript();
        }
        private static function loadSearchTag () {
            ?>
                <div class="search-container">
                    <input 
                        type="text" 
                        class="form-control search-input"
                        id="index-search" 
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
                document.getElementById('index-search').addEventListener('input', function () {
                    var input = document.getElementById('index-search');
                    var filter = input.value.toUpperCase();
                    var table = document.getElementById('index-table');
                    var trElements = table.getElementsByTagName('tr');

                    console.log(trElements);
                    for (var i = 0; i < trElements.length; i++) {
                        var td = trElements[i].getElementsByTagName('td')[1];
                        if (td) {
                            var txtValue = td.textContent || td.innerText;
                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                trElements[i].style.display = '';
                            } else {
                                trElements[i].style.display = 'none';
                            }
                        }
                    }
                });
            </script>
            <?php
        }
    }
?>