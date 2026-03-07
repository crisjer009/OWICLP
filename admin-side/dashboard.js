document.addEventListener('DOMContentLoaded', () => {

    // ================= Sidebar Navigation =================
    function showSection(sectionId) {

        $('#dashboardContent, #FolderContent, #FlistContent, #ticketContent, #transactionsContent, #reportsContent, #settingsContent').hide();

        $(sectionId).show();

        if (sectionId === '#reportsContent') {
            loadReportsCharts();
        }
    }

    $("#dashboardLink").click(function(e){
        e.preventDefault();
        showSection("#dashboardContent");
    });

    $("#myFoldersLink").click(function(e){
        e.preventDefault();
        showSection("#FolderContent");
    });

    $("#departmentFoldersLink").click(function(e){
        e.preventDefault();
        showSection("#FlistContent");
    });

    $("#myGalleryLink").click(function(e){
        e.preventDefault();
        showSection("#MGallerysContent");
    });

    $("#settingsLink").click(function(e){
        e.preventDefault();
        showSection("#settingsContent");
    });

    showSection("#dashboardContent");


    // ================= Table Search =================
    const searchInput = document.querySelector('.top .search input');
    const tableRows = document.querySelectorAll('.data-table tbody tr');

    if (searchInput) {
        searchInput.addEventListener('input', function () {

            const searchTerm = this.value.toLowerCase();

            tableRows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                row.style.display = rowText.includes(searchTerm) ? '' : 'none';
            });

        });
    }


    // ================= FOLDER MODAL =================

    window.openFolderModal = function(){
        document.getElementById("folderModal").style.display = "flex";
    }

    window.closeFolderModal = function(){
        document.getElementById("folderModal").style.display = "none";
    }


    // ================= CREATE FOLDER =================

    window.createFolder = function(){

        const name = document.getElementById("folderName").value.trim();
        const type = document.getElementById("folderType").value;
        const source = document.getElementById("folderSource").value;

        if(name === ""){
            alert("Folder name required");
            return;
        }

        const container = document.getElementById("foldersContainer");

        let iconClass = "doc-color";
        let icon = "fa-folder";

        if(type === "spreadsheet"){
            iconClass = "proj-color";
            icon = "fa-table";
        }

        if(type === "pdf"){
            iconClass = "doc-color";
            icon = "fa-file-pdf";
        }

        if(type === "archive"){
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
    }



    // ================= GRID / LIST TOGGLE =================

    window.setGrid = function(){

        const container = document.getElementById("foldersContainer");

        container.classList.remove("folders-list");
        container.classList.add("folders-grid");

    }

    window.setList = function(){

        const container = document.getElementById("foldersContainer");

        container.classList.remove("folders-grid");
        container.classList.add("folders-list");

    }



    // ================= FILTER SYSTEM =================

    const typeFilter = document.getElementById("typeFilter");
    const modifiedFilter = document.getElementById("modifiedFilter");
    const sourceFilter = document.getElementById("sourceFilter");

    function applyFilters(){

        const typeValue = typeFilter.value;
        const modifiedValue = modifiedFilter.value;
        const sourceValue = sourceFilter.value;

        const folders = document.querySelectorAll(".folder-item");

        folders.forEach(folder => {

            const type = folder.getAttribute("data-type");
            const modified = folder.getAttribute("data-modified");
            const source = folder.getAttribute("data-source");

            let show = true;

            if(typeValue !== "all" && type !== typeValue){
                show = false;
            }

            if(modifiedValue !== "all" && modified !== modifiedValue){
                show = false;
            }

            if(sourceValue !== "all" && source !== sourceValue){
                show = false;
            }

            folder.style.display = show ? "flex" : "none";

        });

    }

    if(typeFilter) typeFilter.addEventListener("change", applyFilters);
    if(modifiedFilter) modifiedFilter.addEventListener("change", applyFilters);
    if(sourceFilter) sourceFilter.addEventListener("change", applyFilters);

});