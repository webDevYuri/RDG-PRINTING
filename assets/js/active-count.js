function fetchActiveCount() {
    $.ajax({
        url: '../admin/active-job-req-count.php', 
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.activeCount !== undefined) {
                $('#activeCountBadge').text(data.activeCount); 
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching active count:', error);
        }
    });
}

setInterval(fetchActiveCount, 1000);
fetchActiveCount();