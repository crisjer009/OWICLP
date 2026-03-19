document.addEventListener('DOMContentLoaded', () => {

    // =====================================================
    // SIDEBAR NAVIGATION
    // =====================================================

    function showSection(sectionId) {

        $('#dashboardContent, #myFoldersContent, #departmentFoldersContent, #ticketContent, #transactionsContent, #reportsContent, #settingsContent, #usersManagementContent').hide();

        $(sectionId).show();

        if (sectionId === "#reportsContent") {
            if (typeof loadReportsCharts === "function") {
                loadReportsCharts();
            }
        }
    }

    $("#dashboardLink").click(function (e) {
        e.preventDefault();
        showSection("#dashboardContent");
    });

    $("#myFoldersLink").click(function (e) {
        e.preventDefault();
        showSection("#myFoldersContent");
    });

    $("#departmentFoldersLink").click(function (e) {
        e.preventDefault();
        showSection("#departmentFoldersContent");
    });

    $("#usersManagementLink").click(function (e) {
        e.preventDefault();
        showSection("#usersManagementContent");
    });

    $("#settingsLink").click(function (e) {
        e.preventDefault();
        showSection("#settingsContent");
    });

    // Default section
    showSection("#dashboardContent");


    // =====================================================
    // FOLDER SEARCH
    // =====================================================

    const folderSearch = document.getElementById("folderSearch");

    if (folderSearch) {
        folderSearch.addEventListener("input", function () {

            const search = this.value.toLowerCase();
            const folders = document.querySelectorAll("#foldersContainer .folder-item");

            folders.forEach(folder => {

                const name = folder.querySelector("h4").textContent.toLowerCase();

                folder.style.display = name.includes(search)
                    ? "flex"
                    : "none";

            });

        });
    }


    // =====================================================
    // MODAL CONTROLS
    // =====================================================

    window.openFolderModal = function () {
        document.getElementById("folderModal").style.display = "flex";
    };

    window.closeFolderModal = function () {
        document.getElementById("folderModal").style.display = "none";
    };


    // =====================================================
    // CREATE FOLDER
    // =====================================================

    window.createFolder = function () {

        const name = document.getElementById("folderName").value.trim();
        const type = document.getElementById("folderType").value;
        const source = document.getElementById("folderSource").value;

        if (name === "") {
            alert("Folder name required");
            return;
        }

        const container = document.getElementById("foldersContainer");

        let iconClass = "doc-color";
        let icon = "fa-folder";

        if (type === "spreadsheet") {
            iconClass = "proj-color";
            icon = "fa-table";
        }

        if (type === "pdf") {
            iconClass = "doc-color";
            icon = "fa-file-pdf";
        }

        if (type === "archive") {
            iconClass = "arch-color";
            icon = "fa-archive";
        }

        const folder = document.createElement("div");
        folder.className = "folder-item";

        folder.setAttribute("data-type", type);
        folder.setAttribute("data-modified", "today");
        folder.setAttribute("data-source", source);

        folder.innerHTML = `
            <div class="folder-icon ${iconClass}">
                <i class="fas ${icon}"></i>
            </div>

            <div class="folder-info">
                <h4>${name}</h4>
                <span>0 Files</span>
                <small>Modified: Today</small>
                <small>Source: ${source}</small>
            </div>

            <button class="folder-options">
                <i class="fas fa-ellipsis-v"></i>
            </button>
        `;

        container.appendChild(folder);

        document.getElementById("folderName").value = "";

        closeFolderModal();
    };


    // =====================================================
    // GRID / LIST TOGGLE
    // =====================================================

    window.setGrid = function () {

        const container = document.getElementById("foldersContainer");

        if (container) {
            container.classList.remove("my-folders-list");
        }

    };

    window.setList = function () {

        const container = document.getElementById("foldersContainer");

        if (container) {
            container.classList.add("my-folders-list");
        }

    };


    // =====================================================
    // FOLDER FILTERS
    // =====================================================

    const typeFilter = document.getElementById("typeFilter");
    const modifiedFilter = document.getElementById("modifiedFilter");
    const sourceFilter = document.getElementById("sourceFilter");

    function applyFilters() {

        const typeValue = typeFilter ? typeFilter.value : "all";
        const modifiedValue = modifiedFilter ? modifiedFilter.value : "all";
        const sourceValue = sourceFilter ? sourceFilter.value : "all";

        const folders = document.querySelectorAll("#foldersContainer .folder-item");

        folders.forEach(folder => {

            const type = folder.getAttribute("data-type");
            const modified = folder.getAttribute("data-modified");
            const source = folder.getAttribute("data-source");

            let show = true;

            if (typeValue !== "all" && type !== typeValue) show = false;
            if (modifiedValue !== "all" && modified !== modifiedValue) show = false;
            if (sourceValue !== "all" && source !== sourceValue) show = false;

            folder.style.display = show ? "flex" : "none";

        });
    }

    if (typeFilter) typeFilter.addEventListener("change", applyFilters);
    if (modifiedFilter) modifiedFilter.addEventListener("change", applyFilters);
    if (sourceFilter) sourceFilter.addEventListener("change", applyFilters);


    // =====================================================
    // USER MANAGEMENT FILTERS
    // =====================================================

    const userSearch = document.getElementById("userSearch");
    const deptFilter = document.getElementById("deptFilter");

    function filterUsers() {

        const searchTerm = userSearch ? userSearch.value.toLowerCase() : "";
        const deptValue = deptFilter ? deptFilter.value.toLowerCase() : "all";

        const rows = document.querySelectorAll("#userTableBody tr");

        rows.forEach(row => {

            const userName = row.querySelector(".user-name").textContent.toLowerCase();
            const userDept = row.getAttribute("data-dept").toLowerCase();

            const matchesSearch = userName.includes(searchTerm);
            const matchesDept = (deptValue === "all" || userDept === deptValue);

            row.style.display = (matchesSearch && matchesDept)
                ? ""
                : "none";

        });
    }

    if (userSearch) userSearch.addEventListener("input", filterUsers);
    if (deptFilter) deptFilter.addEventListener("change", filterUsers);

});