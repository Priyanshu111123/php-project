
setInterval(function() {
    fetch('fetch_votes.php')
        .then(response => response.json())
        .then(data => updateDashboard(data));
}, 5000);

function updateDashboard(data) {
    document.getElementById('results').innerHTML = JSON.stringify(data);
}
