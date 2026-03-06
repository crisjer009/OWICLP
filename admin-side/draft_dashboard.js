document.addEventListener('DOMContentLoaded', () => {
    
    // ======================= Sidebar Navigation Toggle=============================
    function showSection(sectionId) {
        // Hide all content sections
        $('#dashboardContent, #branchesContent, #StocksContent,#ticketContent, #transactionsContent, #reportsContent, #settingsContent').hide();
        $(sectionId).show();

        // Load charts if reports section is shown
        if (sectionId === '#reportsContent') {
            loadReportsCharts();
        }
    }

    $("#dashboardLink").click(e => { e.preventDefault(); showSection("#dashboardContent"); });
    $("#usersLink").click(e => { e.preventDefault(); showSection("#branchesContent"); });
    $("#suppliersStockLink").click(e => { e.preventDefault(); showSection("#StocksContent"); });
    $("#ticketManagementLink").click(e =>{e.preventDefault(); showSection("#ticketContent")})
    $("#reportsLink").click(e => { e.preventDefault(); showSection("#reportsContent"); });
    $("#settingsLink").click(e => { e.preventDefault(); showSection("#settingsContent"); });

    // Show dashboard by default
    showSection("#dashboardContent");

    // ==========================================
    // Table Search Functionality
    // ==========================================
    const searchInput = document.querySelector('.top .search input');
    const tableRows = document.querySelectorAll('.data-table tbody tr');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();

            tableRows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                row.style.display = rowText.includes(searchTerm) ? '' : 'none';
            });
        });
    }

    // ====================== Stock Movement Chart (Chart.js)==================================
    const chartPlaceholder = document.querySelector('.chart-placeholder');
    
    if (chartPlaceholder) {
        const ctx = document.createElement('canvas');
        // Replace placeholder text with canvas
        chartPlaceholder.innerHTML = '';
        chartPlaceholder.appendChild(ctx);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                datasets: [{
                    label: 'Stock In',
                    data: [120, 150, 100, 180],
                    borderColor: '#38bdf8', // Blue
                    backgroundColor: 'rgba(56, 189, 248, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Stock Out',
                    data: [80, 100, 130, 90],
                    borderColor: '#ef4444', // Red
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: 'white' // Make legend text visible on dark background
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: { color: 'rgba(255, 255, 255, 0.7)' },
                        grid: { color: 'rgba(255, 255, 255, 0.1)' }
                    },
                    y: {
                        ticks: { color: 'rgba(255, 255, 255, 0.7)' },
                        grid: { color: 'rgba(255, 255, 255, 0.1)' }
                    }
                }
            }
        });
    }

    // =============================== Branch Management Table Data=================================
    const branchSelect = document.getElementById('branchSelect');
    const tableWrapper = document.getElementById('branchTableWrapper');
    const tableBody = document.getElementById('branchTableBody');

    // Fake Database for Branch Users
    const branchData = {
        "Makati": [
            { id: "USR-001", name: "Sherlyn Ramos", branch: "Makati", role: "Manager", status: "Active" },
            { id: "USR-002", name: "Yasmin Pilapil", branch: "Makati", role: "Staff", status: "Active" }
        ],
        "Cubao": [
            { id: "USR-003", name: "Leinn Margaret", branch: "Cubao", role: "Supervisor", status: "Active" }
        ],
        "Batangas": [
            { id: "USR-004", name: "Justin Parlan", branch: "Batangas", role: "Staff", status: "Active" }
        ],
        "Bulacan": [
            { id: "USR-005", name: "Gab Zapanta", branch: "Bulacan", role: "Staff", status: "Active" },
            { id: "USR-006", name: "Princess Reyes", branch: "Bulacan", role: "Staff", status: "Active" }
        ],
        "Antipolo": [
            { id: "USR-007", name: "Robvick Besiata", branch: "Antipolo", role: "Supervisor", status: "Active" },
            { id: "USR-008", name: "Gab Zapanta", branch: "Antipolo", role: "Staff", status: "Inactive" }
        ]
    };

    if (branchSelect) {
        branchSelect.addEventListener('change', function() {
            const selectedBranch = this.value;
            tableBody.innerHTML = '';

            if (selectedBranch && branchData[selectedBranch]) {
                branchData[selectedBranch].forEach(user => {
                    const row = `
                        <tr>
                            <td>${user.id}</td>
                            <td>${user.name}</td>
                            <td>${user.branch}</td>
                            <td>${user.role}</td>
                            <td>
                                <span class="status ${user.status === 'Active' ? 'delivered' : 'pending'}">
                                    ${user.status}
                                </span>
                            </td>
                            <td>
                                <button class="edit-btn" onclick="openEditModal('${user.id}', '${user.name}', '${user.branch}', '${user.role}', '${user.status}')">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                            </td>
                        </tr>
                    `;
                    tableBody.innerHTML += row;
                });
                tableWrapper.style.display = 'block';
            } else {
                tableWrapper.style.display = 'none';
            }
        });
    }

    // --- EDIT FORM MODAL LOGIC ---
    const modal = document.getElementById('editModal');

    window.openEditModal = function(id, name, branch, role, status) {
        document.getElementById('editUserId').value = id;
        document.getElementById('editName').value = name;
        document.getElementById('editBranch').value = branch;
        document.getElementById('editRole').value = role;
        document.getElementById('editStatus').value = status;
        
        modal.style.display = 'flex';
    }

    window.closeModal = function() {
        modal.style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // ===================================  Stocks Management ==========================================
    
    const supplierData = [
        {
            product: "Ergonomic Desk Chair",
            supplier: "Office Furniture Inc.",
            contact: "Office Furniture Inc.",
            address: "123 Makati Business Park, Makati City",
            pricing: "₱4,500 per unit (5% discount for 50+ orders)",
            leadTime: "5 days",
            reorderDate: "March 10, 2026"
        },
        {
            product: "LaserJet Office Printer",
            supplier: "Tech Solutions Ltd.",
            contact: "Tech Solutions Ltd.",
            address: "45 Cubao Tech Center, Quezon City",
            pricing: "₱12,000 per unit (10% bulk discount)",
            leadTime: "7 days",
            reorderDate: "March 15, 2026"
        },
        {
            product: "Bond Paper A4 (Sub 20)",
            supplier: "Paper Corp Publishing",
            contact: "Paper Corp Publishing",
            address: "88 Paper Street, Bulacan",
            pricing: "₱180 per ream",
            leadTime: "4 days",
            reorderDate: "March 5, 2026"
        },
        {
            product: "Modular Office Desk",
            supplier: "Office Furniture Inc.",
            contact: "Office Furniture Inc.",
            address: "123 Makati Business Park, Makati City",
            pricing: "₱8,500 per unit",
            leadTime: "6 days",
            reorderDate: "March 12, 2026"
        },
        {
            product: "24-inch Monitor",
            supplier: "Tech Solutions Ltd.",
            contact: "Tech Solutions Ltd.",
            address: "45 Cubao Tech Center, Quezon City",
            pricing: "₱6,500 per unit",
            leadTime: "5 days",
            reorderDate: "March 8, 2026"
        }
    ];

    const supplierTableBody = document.querySelector('#StocksContent .data-table tbody');

    if (supplierTableBody) {
        supplierData.forEach(item => {
            const row = `
                <tr>
                    <td>${item.product}</td>
                    <td>${item.supplier}</td>
                    <td>${item.contact}</td>
                    <td>${item.address}</td>
                    <td>${item.pricing}</td>
                    <td>${item.leadTime}</td>
                    <td>${item.reorderDate}</td>
                </tr>
            `;
            supplierTableBody.innerHTML += row;
        });
    }

    // ==================================== Inter-Branch Transfers Logic ==========================================
    let transfersData = [
        { id: 1, item: "Ergonomic Chair", from: "Quezon City", to: "Antipolo", qty: 5, status: "In-Transit", date: "2026-03-01" },
        { id: 2, item: "LaserJet Printer", from: "Quezon City", to: "Batangas", qty: 2, status: "Pending", date: "2026-03-02" },
        { id: 3, item: "Ergonomic Chair", from: "Quezon City", to: "Makati", qty: 3, status: "Completed", date: "2026-02-28" },
        { id: 4, item: "Office Desk", from: "Quezon City", to: "Bulacan", qty: 10, status: "In-Transit", date: "2026-03-03" }
    ];

    const transfersTableBody = document.getElementById('transfersTableBody');

    function renderTransfers() {
        if (!transfersTableBody) return;
        transfersTableBody.innerHTML = '';
        transfersData.forEach(trf => {
            let actionBtn = '';
            if (trf.status !== 'Completed') {
                actionBtn = `<button class="action-btn" onclick="completeTransfer(${trf.id})">Complete</button>`;
            }

            const row = `
                <tr>
                    <td>${trf.item}</td>
                    <td>${trf.from}</td>
                    <td>${trf.to}</td>
                    <td>${trf.qty}</td>
                    <td><span class="status ${trf.status.toLowerCase().replace(' ', '-')}">${trf.status}</span></td>
                    <td>${trf.date}</td>
                    <td>${actionBtn}</td>
                </tr>
            `;
            transfersTableBody.innerHTML += row;
        });
    }

    renderTransfers();

    // --Complete Transfer Function ---
    window.completeTransfer = (id) => {
        const transfer = transfersData.find(t => t.id === id);
        if (transfer) {
            transfer.status = "Completed";
            alert(`Transfer of ${transfer.item} to ${transfer.to} completed. Inventory updated.`);
            renderTransfers();
            renderChart(); 
        }
    }

    // --- Transfer Status Chart (Chart.js) ---
    let myChart = null;
    function renderChart() {
        const chartCanvas = document.getElementById('transferStatusChart');
        if (!chartCanvas) return;
        const ctx = chartCanvas.getContext('2d');
        
        if (myChart) myChart.destroy();

        const statusCounts = transfersData.reduce((acc, curr) => {
            acc[curr.status] = (acc[curr.status] || 0) + 1;
            return acc;
        }, {});

        myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'In-Transit', 'Completed'],
                datasets: [{
                    data: [
                        statusCounts['Pending'] || 0,
                        statusCounts['In-Transit'] || 0,
                        statusCounts['Completed'] || 0
                    ],
                    backgroundColor: ['#fbbf24', '#38bdf8', '#34d399'], // Yellow, Blue, Green
                    borderColor: 'rgba(0,0,0,0.1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { color: 'white' }
                    }
                }
            }
        });
    }
    
    renderChart();


             // ======================= Ticketing section ===================== //
    
        









    // =============================== Reports Section Charts (amCharts 5) ==========================================
    function loadReportsCharts() {
        // Ensure amCharts is loaded
        if (typeof am5 === 'undefined') return;

        am5.ready(function() {

            // --- 1. PIE CHART (Sales Distribution) ---
            var rootPie = am5.Root.new("chartdiv");
            rootPie.setThemes([am5themes_Animated.new(rootPie)]);

            var chartPie = rootPie.container.children.push(
                am5percent.PieChart.new(rootPie, { layout: rootPie.horizontalLayout })
            );

            var seriesPie = chartPie.series.push(
                am5percent.PieSeries.new(rootPie, {
                    valueField: "value",
                    categoryField: "category",
                    innerRadius: am5.percent(50)
                })
            );

            seriesPie.data.setAll([
                { category: "Puregold Makati", value: 550 },
                { category: "Puregold Sucat", value: 320 },
                { category: "Puregold Taguig", value: 480 },
                { category: "Puregold Antipolo",value: 250},
                { category: "Puregold Marikina", value: 150 }
            ]);

            seriesPie.labels.template.set("visible", false);
            seriesPie.ticks.template.set("visible", false);

            // Pie Legend
            var legendPie = rootPie.container.children.push(am5.Legend.new(rootPie, {
                centerY: am5.percent(50),
                y: am5.percent(50),
                layout: rootPie.verticalLayout
            }));
            legendPie.data.setAll(seriesPie.dataItems);
            
            // Ensure legend text is white for dark theme
            legendPie.labels.template.setAll({ fill: am5.color(0xffffff) });
            legendPie.valueLabels.template.setAll({ fill: am5.color(0xffffff) });


            // --- 2. LINE CHART (Sales Trend) ---
            var rootLine = am5.Root.new("linechartdiv");
            rootLine.setThemes([am5themes_Animated.new(rootLine)]);

            var chartLine = rootLine.container.children.push(
                am5xy.XYChart.new(rootLine, {
                    panX: true, panY: true, wheelX: "panX", wheelY: "zoomX"
                })
            );

            // Data
            var data = [
                { date: new Date(2026, 0, 1).getTime(), sales: 500, visitors: 300 },
                { date: new Date(2026, 1, 1).getTime(), sales: 600, visitors: 350 },
                { date: new Date(2026, 2, 1).getTime(), sales: 800, visitors: 400 },
                { date: new Date(2026, 3, 1).getTime(), sales: 700, visitors: 380 }
            ];

            // Axes
            var xAxis = chartLine.xAxes.push(am5xy.DateAxis.new(rootLine, {
                baseInterval: { timeUnit: "month", count: 1 },
                renderer: am5xy.AxisRendererX.new(rootLine, {}),
                tooltip: am5.Tooltip.new(rootLine, {})
            }));

            var yAxis = chartLine.yAxes.push(am5xy.ValueAxis.new(rootLine, {
                renderer: am5xy.AxisRendererY.new(rootLine, {})
            }));

            // Series 1 (Sales)
            var seriesSales = chartLine.series.push(am5xy.LineSeries.new(rootLine, {
                name: "Sales",
                xAxis: xAxis, yAxis: yAxis,
                valueYField: "sales", valueXField: "date",
                tooltip: am5.Tooltip.new(rootLine, { labelText: "{valueY}" })
            }));

            // Series 2 (Visitors)
            var seriesVisitors = chartLine.series.push(am5xy.LineSeries.new(rootLine, {
                name: "Visitors",
                xAxis: xAxis, yAxis: yAxis,
                valueYField: "visitors", valueXField: "date",
                tooltip: am5.Tooltip.new(rootLine, { labelText: "{valueY}" })
            }));

            seriesSales.data.setAll(data);
            seriesVisitors.data.setAll(data);

            // Line Legend
            var legendLine = rootLine.container.children.push(am5.Legend.new(rootLine, {
                layout: rootLine.horizontalLayout
            }));
            legendLine.data.setAll(chartLine.series.values);
            legendLine.labels.template.setAll({ fill: am5.color(0xffffff) });

            seriesSales.appear(1000);
            seriesVisitors.appear(1000);
            chartLine.appear(1000, 100);

        });
    }
});