$(document).ready(function(){

    function showSection(sectionId){
        $("#dashboardContent, #usersContent, #pointsContent, #rewardsContent, #transactionsContent, #reportsContent, #settingsContent").hide();
        $(sectionId).show();
    }

    $("#dashboardLink").click(e => { e.preventDefault(); showSection("#dashboardContent"); });
    $("#usersLink").click(e => { e.preventDefault(); showSection("#usersContent"); });
    $("#pointsLink").click(e => { e.preventDefault(); showSection("#pointsContent"); });
    $("#rewardsLink").click(e => { e.preventDefault(); showSection("#rewardsContent"); });
    $("#transactionsLink").click(e => { e.preventDefault(); showSection("#transactionsContent"); });
    $("#reportsLink").click(e => { e.preventDefault(); showSection("#reportsContent"); });
    $("#settingsLink").click(e => { e.preventDefault(); showSection("#settingsContent"); });

    showSection("#dashboardContent");

    // ---------- FAKE DATA ----------
    function generateGrowthData(start, increase, months = 6) {
        let data = [];
        let value = start;
        for (let i = 0; i < months; i++) {
            value += Math.floor(Math.random() * increase);
            data.push(value);
        }
        return data;
    }

    const labels = ['Jan','Feb','Mar','Apr','May','Jun'];
    const usersData = generateGrowthData(200, 300);
    const pointsData = generateGrowthData(2000, 3000);
    const transactionsData = generateGrowthData(50, 150);
    const rewardsData = [40, 25];

    // ---------- MINI OPTIONS ----------
    const miniOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false }},
        scales: { x: { display: false }, y: { display: false }},
        elements: { point: { radius: 0 }}
    };

    // ---------- MINI CHARTS ----------
    new Chart($("#usersMiniChart"), {
        type: 'line',
        data: { labels, datasets: [{ data: usersData, borderColor: '#111', backgroundColor: 'rgba(0,0,0,.15)', fill: true, tension: .4 }] },
        options: miniOptions
    });

    new Chart($("#pointsMiniChart"), {
        type: 'bar',
        data: { labels, datasets: [{ data: pointsData, backgroundColor: 'rgba(0,0,0,.35)' }] },
        options: miniOptions
    });

    new Chart($("#rewardsMiniChart"), {
        type: 'doughnut',
        data: { labels: ['Active','Redeemed'], datasets: [{ data: rewardsData, backgroundColor: ['#111','rgba(27,24,24,0.25)'] }] },
        options: { responsive:true, maintainAspectRatio:false, plugins:{ legend:{ display:false }} }
    });

    new Chart($("#transactionsMiniChart"), {
        type: 'line',
        data: { labels, datasets: [{ data: transactionsData, borderColor: '#000', backgroundColor: 'rgba(255,255,255,0.8)', fill:true, tension:.4 }] },
        options: miniOptions
    });

    // ---------- MAIN DASHBOARD CHARTS ----------
    new Chart($("#usersChart"), {
        type: 'line',
        data: { labels, datasets: [{ label: 'Users Growth', data: usersData, borderColor: '#3b82f6', backgroundColor: 'rgba(59,130,246,.2)', fill:true, tension:.4 }] }
    });

    new Chart($("#pointsChart"), {
        type: 'bar',
        data: { labels, datasets: [{ label: 'Points Activity', data: pointsData, backgroundColor: '#3b82f6' }] }
    });

    // ---------- YEARLY SALES CHART ----------
    new Chart($("#yearlySalesChart"), {
        type: 'bar',
        data: {
            labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            datasets: [{
                label: 'Sales ($)',
                data: [1200, 1500],
                backgroundColor: '#10b981'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false }},
            scales: { y: { beginAtZero: true }}
        }
    });

});
