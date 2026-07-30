const leadDrawer = document.getElementById("leadDrawer");
const drawerOverlay = document.getElementById("drawerOverlay");
const drawerContent = document.getElementById("leadDrawerContent");
const closeDrawer = document.getElementById("closeDrawer");

/*=========================================
  Open Lead Drawer
=========================================*/

document.querySelectorAll(".openLeadBtn").forEach(button => {

    button.addEventListener("click", function () {

        const id = this.dataset.id;

        drawerOverlay.classList.add("active");
        leadDrawer.classList.add("active");

        drawerContent.innerHTML = `
            <div class="drawer-loading">
                <i class="fa-solid fa-spinner fa-spin"></i>
                <p>Loading Seller Lead...</p>
            </div>
        `;

        fetch("ajax/get-seller-lead.php?id=" + id)

        .then(response => {

            if (!response.ok) {

                throw new Error("Unable to load seller lead.");

            }

            return response.text();

        })

.then(html => {

    drawerContent.innerHTML = html;

    const row = button.closest("tr");

    if (!row) return;

    if (row.dataset.read === "0") {

        row.dataset.read = "1";

        row.cells[0].innerHTML = `
            <span class="badge">
                Viewed
            </span>
        `;

        const badge = document.getElementById("sellerLeadBadge");

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
  Save Seller Lead
==================================================*/

document.addEventListener("click", function (e) {

    if (!e.target.closest("#saveLeadBtn")) return;

    const leadId = document.getElementById("leadId").value;
    const status = document.getElementById("leadStatus").value;
    const notes = document.getElementById("leadNotes").value;

    const formData = new FormData();

    formData.append("id", leadId);
    formData.append("status", status);
    formData.append("notes", notes);

    fetch("ajax/update-seller-lead.php", {

        method: "POST",

        body: formData

    })

   .then(async response => {

    const text = await response.text();

    console.log("SERVER RESPONSE:");
    console.log(text);

    return JSON.parse(text);

})

.then(data => {

        if (data.success) {

            alert("Lead updated successfully.");

            location.reload();

        } else {

            alert(data.message);

        }

    })

    .catch(error => {

        console.error(error);

        alert("Something went wrong while saving.");

    });

});
/*==================================================
  Delete Seller Lead
==================================================*/

document.addEventListener("click", function (e) {

    let leadId = null;
    let tableRow = null;

    /* Delete from table */

    const tableButton = e.target.closest(".deleteLeadBtn");

    if (tableButton) {
        leadId = tableButton.dataset.id;
        tableRow = tableButton.closest("tr");
    }

    /* Delete from drawer */

    const drawerButton = e.target.closest("#deleteLeadBtn");

    if (drawerButton) {
        leadId = document.getElementById("leadId").value;
    }

    if (!leadId) return;

    if (!confirm("Are you sure you want to permanently delete this lead?")) {
        return;
    }

    const formData = new FormData();
    formData.append("id", leadId);

    fetch("ajax/delete-seller-lead.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {

        if (!data.success) {
            alert(data.message);
            return;
        }

        alert(data.message);

        /* If deleted from table */

        if (tableRow) {
            tableRow.remove();
        }

        /* If deleted from drawer */

        if (leadDrawer.classList.contains("active")) {

            leadDrawer.classList.remove("active");
            drawerOverlay.classList.remove("active");

            location.reload();
        }

    })
    .catch(error => {

        console.error(error);

        alert("Unable to delete the lead.");

    });

});
/*==================================================
  Combined Search + Status Filter
==================================================*/

const searchInput = document.getElementById("searchLead");
const statusFilter = document.getElementById("statusFilter");

function filterSellerLeads() {

    const search = searchInput ? searchInput.value.toLowerCase().trim() : "";
    const status = statusFilter ? statusFilter.value.toLowerCase() : "";

    const rows = document.querySelectorAll("#sellerTable tbody tr");

    rows.forEach(row => {

        const rowSearch = (row.dataset.search || "").toLowerCase();
        const rowStatus = (row.dataset.status || "").toLowerCase();

        const matchesSearch =
            search === "" || rowSearch.includes(search);

        const matchesStatus =
            status === "" || rowStatus === status;

        row.style.display =
            (matchesSearch && matchesStatus) ? "" : "none";

    });

}

if (searchInput) {
    searchInput.addEventListener("keyup", filterSellerLeads);
}

if (statusFilter) {
    statusFilter.addEventListener("change", filterSellerLeads);
}
/*==================================================
  Export Filtered Seller Leads
==================================================*/

const exportBtn = document.getElementById("exportBtn");

if (exportBtn) {

    exportBtn.addEventListener("click", function () {

        const search = document.getElementById("searchLead").value;
        const status = document.getElementById("statusFilter").value;

        const url =
            "ajax/export-seller-csv.php?search=" +
            encodeURIComponent(search) +
            "&status=" +
            encodeURIComponent(status);

        window.location.href = url;

    });

}
/*==================================================
  Refresh Seller Leads
==================================================*/

const refreshBtn = document.getElementById("refreshBtn");

if (refreshBtn) {

    refreshBtn.addEventListener("click", function () {

        // Optional: show spinning animation
        const icon = this.querySelector("i");

        if (icon) {
            icon.classList.add("fa-spin");
        }

        location.reload();

    });

}
/*========================================
Quick Status Popover
========================================*/

const popover = document.getElementById("statusPopover");

const quickStatus = document.getElementById("quickStatus");

const statusLeadId = document.getElementById("statusLeadId");

let currentButton = null;

document.addEventListener("click",function(e){

    const btn=e.target.closest(".statusBtn");

    if(btn){

        currentButton=btn;

        statusLeadId.value=btn.dataset.id;

        const rect=btn.getBoundingClientRect();

        popover.style.left=(window.scrollX+rect.left-110)+"px";

        popover.style.top=(window.scrollY+rect.bottom+10)+"px";

        popover.classList.add("active");

        return;

    }

    if(
        !popover.contains(e.target)
    ){

        popover.classList.remove("active");

    }

});

document
.getElementById("saveStatusBtn")
.onclick=function(){

    const fd=new FormData();

    fd.append("id",statusLeadId.value);

    fd.append("status",quickStatus.value);

    fetch("ajax/update-status.php",{

        method:"POST",

        body:fd

    })

    .then(r=>r.json())

    .then(data=>{

        if(!data.success){

            alert(data.message);

            return;

        }

        popover.classList.remove("active");

        location.reload();

    });

};