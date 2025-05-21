function fetchActiveCount() {
    $.ajax({
        url: '../admin/active-job-req-count.php', 
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.activeCount !== undefined) {
                if (data.activeCount > 9) {
                    $('#activeCountBadge').text('9+'); 
                    $('#activeCountBadge').removeClass('rounded-circle');
                } else {
                    $('#activeCountBadge').text(data.activeCount); 
                    $('#activeCountBadge').addClass('rounded-circle'); 
                }
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching active count:', error);
        }
    });
}

setInterval(fetchActiveCount, 1000);
fetchActiveCount();