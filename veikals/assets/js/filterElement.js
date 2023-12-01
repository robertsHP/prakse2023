

document.getElementById('index-search').addEventListener('input', function () {
    filterTable();
});

function filterTable() {
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
}