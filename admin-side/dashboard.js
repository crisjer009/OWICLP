$(document).ready(function(){

    // ==========================
    // SECTION SWITCHING
    // ==========================
    function showSection(sectionId){
        $('#dashboardContent, #usersContent, #pointsContent, #rewardsContent, #transactionsContent, #reportsContent, #settingsContent').hide();        $(sectionId).show();
    }

    $("#dashboardLink").click(e => { e.preventDefault(); showSection("#dashboardContent"); });
    $("#usersLink").click(e => { e.preventDefault(); showSection("#usersContent"); });
    $("#pointsLink").click(e => { e.preventDefault(); showSection("#pointsContent"); });
    $("#rewardsLink").click(e => { e.preventDefault(); showSection("#rewardsContent"); });
    $("#transactionsLink").click(e => { e.preventDefault(); showSection("#transactionsContent"); });
    $("#settingsLink").click(e => { e.preventDefault(); showSection("#settingsContent"); });

    showSection("#dashboardContent");



    // FAKE DATA
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



    // MINI CHART OPTIONS
    const miniOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false }},
        scales: { x: { display: false }, y: { display: false }},
        elements: { point: { radius: 0 }}
    };



    // ==========================
    // MINI CHARTS
    // ==========================
    new Chart($("#usersMiniChart"), {
        type: 'line',
        data: { 
            labels, 
            datasets: [{ 
                data: usersData, 
                borderColor: '#111', 
                backgroundColor: 'rgba(0,0,0,.15)', 
                fill: true, 
                tension: .4 
            }] 
        },
        options: miniOptions
    });

    new Chart($("#pointsMiniChart"), {
        type: 'bar',
        data: { 
            labels, 
            datasets: [{ 
                data: pointsData, 
                backgroundColor: 'rgba(0,0,0,.35)' 
            }] 
        },
        options: miniOptions
    });

    new Chart($("#rewardsMiniChart"), {
        type: 'doughnut',
        data: { 
            labels: ['Active','Redeemed'], 
            datasets: [{ 
                data: rewardsData, 
                backgroundColor: ['#111','rgba(27,24,24,0.25)'] 
            }] 
        },
        options: { 
            responsive:true, 
            maintainAspectRatio:false, 
            plugins:{ legend:{ display:false }} 
        }
    });

    new Chart($("#transactionsMiniChart"), {
        type: 'line',
        data: { 
            labels, 
            datasets: [{ 
                data: transactionsData, 
                borderColor: '#000', 
                backgroundColor: 'rgba(255,255,255,0.8)', 
                fill:true, 
                tension:.4 
            }] 
        },
        options: miniOptions
    });



    // YEARLY SALES CHART (fake data)
    new Chart($("#yearlySalesChart"), {
        type: 'bar',
        data: {
            labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            datasets: [{
                label: 'Sales (₱)',
                data: [1200, 1500, 1750, 2000, 2500, 2800, 3000, 3200, 2900, 3100, 3500, 4000],
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



    // REPORTS SECTION (amCharts 5 Pie chart with legends)
    let chartLoaded = false;

    $("#reportsLink").click(function(e){
        e.preventDefault();
        showSection("#reportsContent");

        if (!chartLoaded) {
            loadReportsChart();
            chartLoaded = true;
        }
    });

    function loadReportsChart(){

    am5.ready(function(){

        var root = am5.Root.new("chartdiv");

        root.setThemes([
            am5themes_Animated.new(root)
        ]);

        var chart = root.container.children.push(
            am5percent.PieChart.new(root, {
                layout: root.horizontalLayout,
                innerRadius: am5.percent(40)
            })
        );

        var series = chart.series.push(
            am5percent.PieSeries.new(root, {
                valueField: "value",
                categoryField: "category"
            })
        );

        series.data.setAll([
            { category: "Puregold Makati", value: 420 },
            { category: "Puregold Cubao", value: 120 },
            { category: "Puregold Antipolo", value: 210 },
            { category: "Puregold Marikina", value: 85 },
            {category: "Puregold Pureza", value: 20}
        ]);

        // Clean flat style
        series.slices.template.setAll({
            strokeOpacity: 0
        });

        series.labels.template.set("visible", false);
        series.ticks.template.set("visible", false);

        // Legend on RIGHT SIDE
        var legendRoot = am5.Root.new("chartlegend");

        legendRoot.setThemes([
            am5themes_Animated.new(legendRoot)
        ]);

        var legend = legendRoot.container.children.push(
            am5.Legend.new(legendRoot, {
                layout: legendRoot.verticalLayout
            })
        );

        legend.data.setAll(series.dataItems);

        series.appear(1000, 100);
    });
}


});
