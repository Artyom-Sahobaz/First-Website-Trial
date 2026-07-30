/*==================================================
    Elements
==================================================*/

const contactDrawer = document.getElementById("contactDrawer");
const drawerOverlay = document.getElementById("drawerOverlay");
const drawerContent = document.getElementById("contactDrawerContent");
const closeDrawer = document.getElementById("closeDrawer");

const searchInput = document.getElementById("searchMessage");
const refreshBtn = document.getElementById("refreshBtn");

document.querySelectorAll(".openContactBtn").forEach(button => {

    button.addEventListener("click", function () {

        const id = this.dataset.id;

        drawerOverlay.classList.add("active");
        contactDrawer.classList.add("active");

        drawerContent.innerHTML = `
            <div class="drawer-loading">
                <i class="fa-solid fa-spinner fa-spin"></i>
                <p>Loading Contact Message...</p>
            </div>
        `;

        fetch("ajax/get-contact-message.php?id=" + id)

        .then(response => {

            if (!response.ok) {

                throw new Error("Unable to load contact message.");

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

        row.cells[4].innerHTML = `
            <span class="badge success">
                Read
            </span>
        `;

        const badge = document.getElementById("contactBadge");

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

                    <h3 style="margin-top:20px;">Error</h3>

                    <p>${error.message}</p>
                </div>
            `;

        });

    });

});
/*==================================================
    Close Drawer
==================================================*/

function closeContactDrawer(){

    contactDrawer.classList.remove("active");
    drawerOverlay.classList.remove("active");

}
closeDrawer.addEventListener("click",closeContactDrawer);

drawerOverlay.addEventListener("click", closeContactDrawer);

/*==================================================
    Search
==================================================*/

if(searchInput){

searchInput.addEventListener("keyup",function(){

    const value=this.value.toLowerCase();

    document.querySelectorAll("#contactTable tbody tr")

    .forEach(function(row){

        const search=row.dataset.search || "";

        row.style.display=
            search.includes(value)
            ? ""
            : "none";

    });

});

}

/*==================================================
    Refresh
==================================================*/

if(refreshBtn){

refreshBtn.addEventListener("click",function(){

    location.reload();

});

}

/*==================================================
    Delete Message
==================================================*/

document.addEventListener("click",function(e){

const btn=e.target.closest(".deleteContactBtn");

if(!btn) return;

const id=btn.dataset.id;

if(!confirm("Delete this contact message?")){

return;

}

fetch("ajax/delete-contact-message.php",{

method:"POST",

headers:{

"Content-Type":"application/x-www-form-urlencoded"

},

body:"id="+encodeURIComponent(id)

})

.then(r=>r.text())

.then(function(){

location.reload();

});

});

/*==================================================
    Mark Read
==================================================*/

document.addEventListener("click",function(e){

const btn=e.target.closest("#markReadBtn");

if(!btn) return;

const id=btn.dataset.id;

fetch("ajax/update-contact-message.php",{

method:"POST",

headers:{

"Content-Type":"application/x-www-form-urlencoded"

},

body:"id="+encodeURIComponent(id)

})

.then(r=>r.text())

.then(function(){

location.reload();

});

});
document.addEventListener("keydown", function(e){

    if(e.key === "Escape"){

        closeContactDrawer();

    }

}); 