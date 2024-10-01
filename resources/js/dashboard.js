

var  fetchDataUrl = $('#data-container').data('fetch-url');

// Function for updating data via AJAX
function fetchData() {
    $.ajax({
        url: fetchDataUrl,
        type: "GET",
        success: function (response) {
            console.log(response)

            // Update balance
            $('#balance').text(response.balance + 'EU');

            // Update list of operations
            let operationsHtml = '';
            response.operations.forEach(function (operation) {
                let rowClass = operation.amount >= 0 ? 'text-blue-600' : 'text-orange-600';
                operationsHtml += '<tr class="' + rowClass + '">';
                operationsHtml += '<td>' + operation.amount + ' EU</td>';
                operationsHtml += '<td>' + operation.description + '</td>';
                operationsHtml += '<td>' + new Date(operation.created_at).toLocaleString('ru-RU', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                }) + '</td>';
                operationsHtml += '</tr>';
            });
            $('#item-lists').html(operationsHtml);

        }
    });
}

// Update data every 5 seconds
setInterval(fetchData, 5000);
