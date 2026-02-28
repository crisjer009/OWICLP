/*  $(document).ready(function(){

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



   $(document).ready(function() {
    // 1. DATA GENERATOR (Creates a realistic upward trend)
    function generateGrowthData(start, variance, months = 6) {
        let data = [];
        let current = start;
        for (let i = 0; i < months; i++) {
            current += Math.floor(Math.random() * variance) + 10;
            data.push(current);
        }
        return data;
    }

    // Prepare the datasets
    const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
    const usersData = generateGrowthData(150, 50);      // Starts at 150, grows by ~50/mo
    const pointsData = generateGrowthData(1000, 500);   // Starts at 1000, grows by ~500/mo
    const transactionsData = generateGrowthData(20, 15); // Starts at 20, grows by ~15/mo
    const rewardsData = [65, 35]; // 65% Active, 35% Redeemed

    // 2. CHART RENDER HELPER (Handles Desktop Re-renders)
    function render(id, config) {
        const chartStatus = Chart.getChart(id);
        if (chartStatus) { chartStatus.destroy(); }
        new Chart(document.getElementById(id), config);
    }

    // 3. MINI CHART CONFIG
    const miniOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: { x: { display: false }, y: { display: false } },
        elements: { point: { radius: 0 }, line: { tension: 0.4, borderWidth: 3 } }
    };

    // --- EXECUTE CHARTS ---

    // Total Users (Indigo Line)
    render("usersMiniChart", {
        type: 'line',
        data: { labels, datasets: [{ data: usersData, borderColor: '#6366f1', backgroundColor: 'rgba(99, 102, 241, 0.1)', fill: true }] },
        options: miniOptions
    });

    // Total Points (Emerald Bars)
    render("pointsMiniChart", {
        type: 'bar',
        data: { labels, datasets: [{ data: pointsData, backgroundColor: '#10b981', borderRadius: 4 }] },
        options: miniOptions
    });

    // Total Rewards (Amber Doughnut)
    render("rewardsMiniChart", {
        type: 'doughnut',
        data: { 
            labels: ['Active', 'Redeemed'], 
            datasets: [{ data: rewardsData, backgroundColor: ['#f59e0b', '#e2e8f0'], borderWidth: 0 }] 
        },
        options: { cutout: '75%', plugins: { legend: { display: false } }, maintainAspectRatio: false }
    });

    // Total Transactions (Rose Line)
    render("transactionsMiniChart", {
        type: 'line',
        data: { labels, datasets: [{ data: transactionsData, borderColor: '#ef4444', backgroundColor: 'rgba(239, 68, 68, 0.1)', fill: true }] },
        options: miniOptions
    });

    

});

  function viewUser(id, name, email, tier, date) {
    const modal = document.getElementById('userModal');
    if (!modal) return;

    // Populate data
    document.getElementById('detID').innerText = id;
    document.getElementById('detName').innerText = name;
    document.getElementById('detEmail').innerText = email;
    document.getElementById('detTier').innerText = tier;
    document.getElementById('detDate').innerText = date;
    
    // Clear old password
    document.getElementById('tempPassDisplay').innerText = "";
    
    // Show modal
    modal.style.display = "block";
}

// 2. Close Modal
function closeModal() {
    const modal = document.getElementById('userModal');
    if (modal) modal.style.display = "none";
}

// 3. Password Generator
function generatePassword() {
    const charset = "abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789!@#$";
    let password = "";
    for (let i = 0; i < 10; i++) {
        password += charset.charAt(Math.floor(Math.random() * charset.length));
    }
    document.getElementById('tempPassDisplay').innerText = password;
}

// 4. User Table Search Filter
function filterUsers() {
    let input = document.getElementById("userSearch").value.toUpperCase();
    let table = document.getElementById("usersTable");
    if (!table) return;
    
    let tr = table.getElementsByTagName("tr");
    for (let i = 1; i < tr.length; i++) {
        let td = tr[i].getElementsByTagName("td")[1]; // Full Name column
        if (td) {
            let txtValue = td.textContent || td.innerText;
            tr[i].style.display = txtValue.toUpperCase().indexOf(input) > -1 ? "" : "none";
        }
    }
}

// 5. Global Click Handler (Close modal when clicking background)
window.onclick = function(event) {
    let modal = document.getElementById('userModal');
    if (event.target == modal) closeModal();
};

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



 


 */

/* =========================================================
    GLOBAL FUNCTIONS (Accessible by HTML onclick)
   ========================================================= */

function viewUser(id, name, email, tier, date) {
    const modal = document.getElementById('userModal');
    if (!modal) return;

    document.getElementById('detID').innerText = id;
    document.getElementById('detName').innerText = name;
    document.getElementById('detEmail').innerText = email;
    document.getElementById('detTier').innerText = tier;
    document.getElementById('detDate').innerText = date;
    
    document.getElementById('tempPassDisplay').innerText = "";
    
    // the modal
    modal.style.display = "block";
}

function closeModal() {
    const modal = document.getElementById('userModal');
    if (modal) modal.style.display = "none";
}

//  Password Generator
function generatePassword() {
    const charset = "abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789!@#$";
    let password = "";
    for (let i = 0; i < 10; i++) {
        password += charset.charAt(Math.floor(Math.random() * charset.length));
    }
    document.getElementById('tempPassDisplay').innerText = password;
}

function filterUsers() {
    let input = document.getElementById("userSearch").value.toUpperCase();
    let table = document.getElementById("usersTable");
    if (!table) return;
    
    let tr = table.getElementsByTagName("tr");
    for (let i = 1; i < tr.length; i++) {
        let td = tr[i].getElementsByTagName("td")[1]; // Full Name column
        if (td) {
            let txtValue = td.textContent || td.innerText;
            tr[i].style.display = txtValue.toUpperCase().indexOf(input) > -1 ? "" : "none";
        }
    }
}


window.onclick = function(event) {
    let modal = document.getElementById('userModal');
    if (event.target == modal) closeModal();
};


function deleteUser(button, userId) {
    if (confirm("Are you sure you want to delete user " + userId + "?")) {
        // Find the <tr> and remove it
        const row = button.closest('tr');
        row.style.opacity = '0';
        setTimeout(() => row.remove(), 300); // Smooth fade out then remove
    }
}
$(document).ready(function() {

    // --- SECTION SWITCHING ---
    function showSection(sectionId) {
        $('#dashboardContent, #usersContent, #pointsContent, #rewardsContent, #transactionsContent, #reportsContent, #settingsContent').hide();
        $(sectionId).show();
    }

    $("#dashboardLink").click(e => { e.preventDefault(); showSection("#dashboardContent"); });
    $("#usersLink").click(e => { e.preventDefault(); showSection("#usersContent"); });
    $("#pointsLink").click(e => { e.preventDefault(); showSection("#pointsContent"); });
    $("#rewardsLink").click(e => { e.preventDefault(); showSection("#rewardsContent"); });
    $("#transactionsLink").click(e => { e.preventDefault(); showSection("#transactionsContent"); });
    $("#settingsLink").click(e => { e.preventDefault(); showSection("#settingsContent"); });
    $("#reportsLink").click(e => { 
        e.preventDefault(); 
        showSection("#reportsContent"); 
        if (!chartLoaded) {
            loadReportsChart();
            chartLoaded = true;
        }
    });

    showSection("#dashboardContent");

    // --- DASHBOARD DATA & CHARTS ---
    function generateGrowthData(start, variance, months = 6) {
        let data = [];
        let current = start;
        for (let i = 0; i < months; i++) {
            current += Math.floor(Math.random() * variance) + 10;
            data.push(current);
        }
        return data;
    }

    function renderMiniChart(id, config) {
        const chartStatus = Chart.getChart(id);
        if (chartStatus) { chartStatus.destroy(); }
        const ctx = document.getElementById(id);
        if (ctx) new Chart(ctx, config);
    }

    const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
    const miniOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: { x: { display: false }, y: { display: false } },
        elements: { point: { radius: 0 }, line: { tension: 0.4, borderWidth: 3 } }
    };

    renderMiniChart("usersMiniChart", {
        type: 'line',
        data: { labels, datasets: [{ data: generateGrowthData(150, 50), borderColor: '#6366f1', backgroundColor: 'rgba(99, 102, 241, 0.1)', fill: true }] },
        options: miniOptions
    });

    renderMiniChart("pointsMiniChart", {
        type: 'bar',
        data: { labels, datasets: [{ data: generateGrowthData(1000, 500), backgroundColor: '#10b981', borderRadius: 4 }] },
        options: miniOptions
    });

    renderMiniChart("rewardsMiniChart", {
        type: 'doughnut',
        data: { 
            labels: ['Active', 'Redeemed'], 
            datasets: [{ data: [65, 35], backgroundColor: ['#f59e0b', '#e2e8f0'], borderWidth: 0 }] 
        },
        options: { cutout: '75%', plugins: { legend: { display: false } }, maintainAspectRatio: false }
    });

    renderMiniChart("transactionsMiniChart", {
        type: 'line',
        data: { labels, datasets: [{ data: generateGrowthData(20, 15), borderColor: '#ef4444', backgroundColor: 'rgba(239, 68, 68, 0.1)', fill: true }] },
        options: miniOptions
    });

   // REPORTS SECTION (the amCharts 5 Pie chart with legends)
    let chartLoaded = false;

    $("#reportsLink").click(function(e){
        e.preventDefault();
        showSection("#reportsContent");

        if (!chartLoaded) {
            loadReportsChart();
            chartLoaded = true;
        }
    });


/* =========================================================
   BRANCH MANAGEMENT FUNCTIONS
   ========================================================= */

function loadBranchUsers() {
    const branchSelect = document.getElementById('branchSelect');
    const table = document.getElementById('usersTable');
    const tbody = document.getElementById('branchUsersBody');
    const selectedBranch = branchSelect.value;

    // 1. Clear previous table data
    tbody.innerHTML = '';

    // 2. Define Data (In real app, this comes from an API/Backend)
    let branchData = {
        'cubao': [
            { id: 'U001', name: 'John Doe', role: 'Admin', email: 'john@example.com', status: 'Active', activity: 'Logged in 10 mins ago' }
        ],
        'antipolo': [
            { id: 'U003', name: 'Kyle Manansala', role: 'Admin', email: 'kyle.m@outlook.ph', status: 'Active', activity: 'Logged in 2 mins ago' },
            { id: 'U005', name: 'Sarah Santos', role: 'Manager', email: 'sarah.s@gmail.com', status: 'Active', activity: 'Updated Inventory 1hr ago' }
        ],
        'santolan': [], // Example of empty branch
        'montalban': []
    };

    // 3. Get data for selected branch
    const data = branchData[selectedBranch] || [];

    // 4. Populate table or hide it
    if (data.length > 0) {
        table.style.display = 'table'; // Show table
        
        data.forEach(user => {
            const row = `
                <tr>
                    <td>${user.id}</td>
                    <td>${user.name}</td>
                    <td>${user.role}</td>
                    <td>${user.email}</td>
                    <td><span class="badge status-active">${user.status}</span></td>
                    <td>${user.activity}</td>
                    <td>
                        <button class="view-btn" onclick="openEditModal('${user.id}', '${user.name}', '${user.email}', '${user.role}')">Edit</button>
                    </td>
                </tr>
            `;
            tbody.innerHTML += row;
        });
    } else {
        table.style.display = 'none'; // Hide table if no data
    }
}

// Open Edit Modal and Populate Data
function openEditModal(id, name, email, role) {
    const modal = document.getElementById('userModal');
    if (!modal) return;

    // Populate form fields
    document.getElementById('detID').innerText = id;
    document.getElementById('detName').value = name;
    document.getElementById('detEmail').value = email;
    // Set select to lowercase to match option values
    document.getElementById('detRole').value = role.toLowerCase();
    
    // Show modal
    modal.style.display = "block";
}

// Close Modal
function closeModal() {
    const modal = document.getElementById('userModal');
    if (modal) modal.style.display = "none";
}

// Save Changes
function saveUserChanges() {
    const id = document.getElementById('detID').innerText;
    const name = document.getElementById('detName').value;
    const email = document.getElementById('detEmail').value;
    const role = document.getElementById('detRole').value;

    // Backend update logic would go here
    alert(`Saving changes for User: ${name} (${id})`);
    
    closeModal();
}

// Close modal when clicking background
window.onclick = function(event) {
    let modal = document.getElementById('userModal');
    if (event.target == modal) closeModal();
};



    
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

        series.slices.template.setAll({
            strokeOpacity: 0
        });

        series.labels.template.set("visible", false);
        series.ticks.template.set("visible", false);

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