$(document).ready(function(){

    // ===== SIDEBAR PAGE SWITCHING =====
    function showSection(sectionId){
        // Hide all sections
        $("#dashboardContent, #earnPointsContent, #rewardsContent").hide();
        // Show selected section
        $(sectionId).show();
    }

    // Click handlers
    $("#dashboardLink").click(function(e){
        e.preventDefault();
        showSection("#dashboardContent");
    });

    $("#earnPointsLink").click(function(e){
        e.preventDefault();
        showSection("#earnPointsContent");
    });

    $("#rewardsLink").click(function(e){
        e.preventDefault();
        showSection("#rewardsContent");
    });

    // Show dashboard by default
    showSection("#dashboardContent");


    // ===== ANIMATED COUNTER =====
    let points = 1256; // replace with PHP value later
    let count = 0;

    let counterInterval = setInterval(function(){
        if(count >= points){
            clearInterval(counterInterval);
        } else {
            count += 25;
            $("#pointsCounter").text(count.toLocaleString());
        }
    }, 30);

    // ===== PROGRESS BAR =====
    let platinumGoal = 3000;
    let percentage = (points / platinumGoal) * 100;

    $("#progressBar").animate({
        width: percentage + "%"
    }, 2000);

    // ===== CHART =====
    const ctx = document.getElementById('pointsChart').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan','Feb','Mar','Apr','May','Jun'],
            datasets: [{
                label: 'Points Earned',
                data: [200, 400, 800, 1000, 1100, 1256],
                borderColor: '#0072ff',
                backgroundColor: 'rgba(0,114,255,0.1)',
                tension: 0.4,
                fill: true,
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            plugins:{
                legend:{display:false}
            },
            scales:{
                y:{
                    beginAtZero:true
                }
            }
        }
    });

});
