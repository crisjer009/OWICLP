$(document).ready(function(){

    // ===== SIDEBAR PAGE SWITCHING =====
    function showSection(sectionId){
        // Hide all sections
        $("#dashboardContent, #earnPointsContent, #rewardsContent, #transactionsContent").hide();
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

    $("#transactionsLink").click(function(e){
        e.preventDefault();
        showSection("#transactionsContent");
    });

    // Show dashboard by default
    showSection("#dashboardContent");


    // ===== ANIMATED COUNTER =====
    let points = 1256; // replace with PHP value later
    let count = 0;

    let counterInterval = setInterval(function(){
        if(count >= points){
            clearInterval(counterInterval);
            $("#pointsCounter").text(points.toLocaleString());
        } else {
            count += 25;
            if(count > points) count = points;
            $("#pointsCounter").text(count.toLocaleString());
        }
    }, 30);

    // ===== PROGRESS BAR =====
    let platinumGoal = 3000;
    let percentage = (points / platinumGoal) * 100;

    $("#progressBar").animate({
        width: percentage + "%"
    }, 2000);

});
