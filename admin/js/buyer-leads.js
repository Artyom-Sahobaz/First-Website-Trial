const leadDrawer = document.getElementById("leadDrawer");
const drawerOverlay = document.getElementById("drawerOverlay");
const drawerContent = document.getElementById("leadDrawerContent");
const closeDrawer = document.getElementById("closeDrawer");

/*=========================================
  Open Buyer Drawer
=========================================*/

document.querySelectorAll(".openBuyerBtn").forEach(button => {

    button.addEventListener("click", function () {

        const id = this.dataset.id;

        drawerOverlay.classList.add("active");
        leadDrawer.classList.add("active");

        drawerContent.innerHTML = `
            <div class="drawer-loading">
                <i class="fa-solid fa-spinner fa-spin"></i>
                <p>Loading Buyer Lead...</p>
            </div>
        `;

        fetch("ajax/get-buyer-lead.php?id=" + id)

        .then(response => {

            if (!response.ok) {

                throw new Error("Unable to load buyer lead.");

            }

            return response.text();

        })

.then(html => {

    drawerContent.innerHTML = html;

    const row = button.closest("tr");

    if (row) {

        const leadCell = row.cells[0];

        const wasUnread = row.querySelector(".badge.info") !== null;

if (wasUnread) {

    leadCell.innerHTML = `
        <span class="badge">
            Viewed
        </span>
    `;

    const badge = document.getElementById("buyerLeadBadge");

    if (badge) {

        let count = parseInt(badge.textContent, 10);

        if (!isNaN(count)) {

            count--;

            if (count <= 0) {

                badge.remove();

            } else {

                badge.textContent = count;

            }

        }

    }

}

    }

})

        .catch(error => {

            drawerContent.innerHTML = `

                <div style="padding:40px;text-align:center;">

                    <i class="fa-solid fa-circle-exclamation"
                       style="font-size:48px;color:#ef4444;"></i>

                    <h3 style="margin-top:20px;">

                        Error

                    </h3>

                    <p>

                        ${error.message}

                    </p>

                </div>

            `;

        });

    });

});

/*=========================================
  Close Drawer
=========================================*/

function closeLeadDrawer(){

    leadDrawer.classList.remove("active");

    drawerOverlay.classList.remove("active");

}

closeDrawer.addEventListener("click", closeLeadDrawer);

drawerOverlay.addEventListener("click", closeLeadDrawer);

document.addEventListener("keydown", function(e){

    if(e.key==="Escape"){

        closeLeadDrawer();

    }

});

/*==================================================
  Search + Status Filter
==================================================*/

const searchInput = document.getElementById("searchLead");

const statusFilter = document.getElementById("statusFilter");

function filterBuyerLeads(){

    const search = searchInput.value.toLowerCase().trim();

    const status = statusFilter.value.toLowerCase();

    const rows = document.querySelectorAll("#buyerTable tbody tr");

    rows.forEach(row=>{

        const rowSearch=(row.dataset.search||"").toLowerCase();

        const rowStatus=(row.dataset.status||"").toLowerCase();

        const matchesSearch =
            search==="" || rowSearch.includes(search);

        const matchesStatus =
            status==="" || rowStatus===status;

        row.style.display =
            (matchesSearch && matchesStatus) ? "" : "none";

    });

}

if(searchInput){

    searchInput.addEventListener("keyup",filterBuyerLeads);

}

if(statusFilter){

    statusFilter.addEventListener("change",filterBuyerLeads);

}

/*==================================================
  Refresh
==================================================*/

const refreshBtn=document.getElementById("refreshBtn");

if(refreshBtn){

    refreshBtn.onclick=function(){

        location.reload();

    };

}

/*==================================================
  Export CSV
==================================================*/

const exportBtn=document.getElementById("exportBtn");

if(exportBtn){

    exportBtn.onclick=function(){

        const search=document.getElementById("searchLead").value;

        const status=document.getElementById("statusFilter").value;

        window.location.href=
        "ajax/export-buyer-csv.php?search="+
        encodeURIComponent(search)+
        "&status="+
        encodeURIComponent(status);

    };

}
/*==================================================
  Save Buyer Lead
==================================================*/

document.addEventListener("click", function (e) {

    if (e.target.id !== "saveLeadBtn") return;

    const id = document.getElementById("leadId").value;
    const status = document.getElementById("leadStatus").value;
    const notes = document.getElementById("leadNotes").value;

    const formData = new FormData();

    formData.append("id", id);
    formData.append("status", status);
    formData.append("notes", notes);

    fetch("ajax/update-buyer-lead.php", {

        method: "POST",
        body: formData

    })

    .then(response => response.text())

    .then(result => {

        if (result.trim() === "success") {

            alert("Buyer lead updated successfully.");

            location.reload();

        } else {

            alert(result);

        }

    })

    .catch(error => {

        console.error(error);

        alert("Unable to update buyer lead.");

    });

});
/*==================================================
  Delete Buyer Lead
==================================================*/

document.addEventListener("click", function (e) {

    if (e.target.id !== "deleteLeadBtn") return;

    if (!confirm("Are you sure you want to delete this buyer lead?")) {
        return;
    }

    const id = document.getElementById("leadId").value;

    const formData = new FormData();

    formData.append("id", id);

    fetch("ajax/delete-buyer-lead.php", {

        method: "POST",
        body: formData

    })

    .then(response => response.text())

    .then(result => {

        if (result.trim() === "success") {

            alert("Buyer lead deleted successfully.");

            location.reload();

        } else {

            alert(result);

        }

    })

    .catch(error => {

        console.error(error);

        alert("Unable to delete buyer lead.");

    });

});
/*==================================================
  Delete Buyer Lead From Table
==================================================*/

document.querySelectorAll(".deleteBuyerBtn").forEach(button => {

    button.addEventListener("click", function () {

        const id = this.dataset.id;

        if (!confirm("Are you sure you want to delete this buyer lead?")) {
            return;
        }

        const formData = new FormData();

        formData.append("id", id);

        fetch("ajax/delete-buyer-lead.php", {

            method: "POST",
            body: formData

        })

        .then(response => response.text())

        .then(result => {

            if (result.trim() === "success") {

                alert("Buyer lead deleted successfully.");

                location.reload();

            } else {

                alert(result);

            }

        })

        .catch(error => {

            console.error(error);

            alert("Unable to delete buyer lead.");

        });

    });

});
/*==================================================
  Quick Status Update
==================================================*/

const statusPopover = document.getElementById("statusPopover");
const quickStatus = document.getElementById("quickStatus");
const statusLeadId = document.getElementById("statusLeadId");
const saveStatusBtn = document.getElementById("saveStatusBtn");

/* Open Popover */

document.querySelectorAll(".buyerStatusBtn").forEach(button => {

    button.addEventListener("click", function (e) {

        e.stopPropagation();

        statusLeadId.value = this.dataset.id;

        statusPopover.style.display = "block";

        const rect = this.getBoundingClientRect();

        statusPopover.style.top =
            (window.scrollY + rect.bottom + 10) + "px";

        statusPopover.style.left =
            (window.scrollX + rect.left - 80) + "px";

    });

});

/* Close when clicking outside */

document.addEventListener("click", function (e) {

    if (!statusPopover.contains(e.target) &&
        !e.target.closest(".buyerStatusBtn")) {

        statusPopover.style.display = "none";

    }

});

/* Save Status */

saveStatusBtn.addEventListener("click", function () {

    const formData = new FormData();

    formData.append("id", statusLeadId.value);
    formData.append("status", quickStatus.value);

    fetch("ajax/update-buyer-status.php", {

        method: "POST",
        body: formData

    })

    .then(response => response.text())
.then(result => {

    if (result.trim() === "success") {

        statusPopover.style.display = "none";

        location.reload();

    } else {

        alert(result);

    }

})

.catch(error => {

    console.error(error);

    alert("Unable to update status.");

});
}); 