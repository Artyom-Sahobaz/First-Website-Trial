document.addEventListener("DOMContentLoaded", () => {

    const typewriterElement = document.getElementById("typewriter-container");

    if(typewriterElement){

        const tokens = [
            ..."Sell Your Mobile Home",
            "<br>",
            ..."Fast for ",
            "<span>",
            ..."Cash",
            "</span>"
        ];

        let index = 0;
        let output = "";

        function type(){

            if(index >= tokens.length){
                return;
            }

            output += tokens[index];

            typewriterElement.innerHTML =
                output + '<span class="cursor">|</span>';

            const current = tokens[index];

            index++;

            // Detect HTML tags properly
            if(current.startsWith("<")){
                setTimeout(type,0);
            }else{
                setTimeout(type,45);
            }

        }

        setTimeout(type,500);

    }


    // ===========================
    // HOW IT WORKS ANIMATION
    // ===========================

    const cards = document.querySelectorAll(".step-card");

    if(cards.length){

        const observer = new IntersectionObserver((entries)=>{

            entries.forEach(entry=>{

                if(entry.isIntersecting){

                    const index = [...cards].indexOf(entry.target);

                    setTimeout(()=>{

                        entry.target.classList.add("show");

                    },index*180);

                }

            });

        },{

            threshold:0.25

        });

        cards.forEach(card=>observer.observe(card));

    }
    const whyImage = document.querySelector(".why-image img");

if(whyImage){

    const imageObserver = new IntersectionObserver((entries)=>{

        entries.forEach(entry=>{

            if(entry.isIntersecting){

                whyImage.classList.add("show");

            }

        });

    },{

        threshold:.3

    });

    imageObserver.observe(whyImage);

}


// ===========================
// WHY US FEATURE ANIMATION
// ===========================

const features = document.querySelectorAll(".feature-card");

if(features.length){

    const featureObserver = new IntersectionObserver((entries)=>{

        entries.forEach(entry=>{

            if(entry.isIntersecting){

                const index = [...features].indexOf(entry.target);

                setTimeout(()=>{

                    entry.target.classList.add("show");

                }, index * 140);

                featureObserver.unobserve(entry.target);

            }

        });

    },{

        threshold:0.25

    });

    features.forEach(feature=>featureObserver.observe(feature));

}
//Sec 4

// ===========================
// SELLER SECTION ANIMATION
// ===========================

const sellerInfo = document.querySelector(".seller-info");
const sellerForm = document.querySelector(".seller-form");

const sellerObserver = new IntersectionObserver((entries)=>{

    entries.forEach(entry=>{

        if(entry.isIntersecting){

            sellerInfo.classList.add("show");

            setTimeout(()=>{

                sellerForm.classList.add("show");

            },250);

        }

    });

},{
    threshold:.25
});

if(sellerInfo){

    sellerObserver.observe(sellerInfo);

}
// ===========================
// BUYER SECTION ANIMATION
// ===========================

const buyerForm = document.querySelector(".buyer-form");
const buyerImage = document.querySelector(".buyer-image");

if(buyerForm && buyerImage){

    const buyerObserver = new IntersectionObserver((entries)=>{

        entries.forEach(entry=>{

            if(entry.isIntersecting){

                buyerForm.classList.add("show");

                setTimeout(()=>{

                    buyerImage.classList.add("show");

                },250);

            }

        });

    },{

        threshold:.25

    });

    buyerObserver.observe(buyerForm);

}
// ===========================
// TRUST SECTION
// ===========================

const trustCards = document.querySelectorAll(".trust-card");

if(trustCards.length){

    const trustObserver = new IntersectionObserver((entries)=>{

        entries.forEach(entry=>{

            if(entry.isIntersecting){

                trustCards.forEach((card,index)=>{

                    setTimeout(()=>{

                        card.classList.add("show");

                    },index*180);

                });

            }

        });

    },{

        threshold:.25

    });

    trustObserver.observe(trustCards[0]);

}
// ===========================
// RESOURCES SECTION
// ===========================

const resourceCards = document.querySelectorAll(".resource-card");

if(resourceCards.length){

    const resourceObserver = new IntersectionObserver((entries)=>{

        entries.forEach(entry=>{

            if(entry.isIntersecting){

                resourceCards.forEach((card,index)=>{

                    setTimeout(()=>{

                        card.classList.add("show");

                    },index*180);

                });

            }

        });

    },{

        threshold:.25

    });

    resourceObserver.observe(resourceCards[0]);

}
 const faqItems = document.querySelectorAll(".faq-item");

 faqItems.forEach(item => {

    const question = item.querySelector(".faq-question");

    question.addEventListener("click", () => {

        if (item.classList.contains("active")) {

            item.classList.remove("active");

        } else {

            faqItems.forEach(faq => faq.classList.remove("active"));

            item.classList.add("active");

        }

    });

 });

});
const sellerForm = document.getElementById("sellerForm");

if(sellerForm){

    sellerForm.addEventListener("submit", function(e){

        e.preventDefault();

        const button = document.getElementById("submitSeller");

        button.disabled = true;
        button.innerHTML = "Submitting...";

        const formData = new FormData(sellerForm);

        fetch("submit-seller.php",{

            method:"POST",

            body:formData

        })

        .then(response => response.json())

        .then(data=>{

    button.disabled = false;
    button.innerHTML = "Get My Cash Offer";

    if(data.success){

       sellerForm.reset();

const modal = document.getElementById("sellerSuccessModal");

modal.style.display = "flex";
document.body.style.overflow = "hidden";

setTimeout(function () {

    modal.style.display = "none";
    document.body.style.overflow = "";

}, 4000);

    }else{

        alert(data.message);

    }

})
        .catch(error=>{

            button.disabled = false;
            button.innerHTML = "Get My Cash Offer";

            alert("Something went wrong. Please try again.");

            console.error(error);

        });

    });

}

document.addEventListener("click", function (e) {

    if (e.target.id === "closeSellerModal") {

        const modal = document.getElementById("sellerSuccessModal");

modal.style.display = "none";
document.body.style.overflow = "";

    }

});
document.addEventListener("click", function (e) {

    const modal = document.getElementById("sellerSuccessModal");

    if (!modal) return;

    // Close only when clicking the dark background
    if (e.target === modal) {
        modal.style.display = "none";
        document.body.style.overflow = "";
    }

});
document.addEventListener("keydown", function (e) {

    if (e.key === "Escape") {

        const modal = document.getElementById("sellerSuccessModal");

modal.style.display = "none";

document.body.style.overflow = "";

    }

});

// ===============================
// BUYER FORM AJAX
// ===============================

const buyerForm = document.getElementById("buyerForm");

if (buyerForm) {

    buyerForm.addEventListener("submit", function (e) {

        e.preventDefault();

        const button = document.getElementById("buyerSubmit");

        button.disabled = true;
        button.innerHTML = "Submitting...";

        const formData = new FormData(buyerForm);

        fetch("submit-buyer.php", {
            method: "POST",
            body: formData
        })

        .then(response => response.json())

        .then(data => {

            button.disabled = false;
            button.innerHTML = "Send My Request";

            if (data.success) {

                buyerForm.reset();

                const modal = document.getElementById("sellerSuccessModal");

                modal.style.display = "flex";
                document.body.style.overflow = "hidden";

                setTimeout(function () {

                    modal.style.display = "none";
                    document.body.style.overflow = "";

                }, 4000);

            } else {

                alert(data.message);

            }

        })

        .catch(error => {

            button.disabled = false;
            button.innerHTML = "Send My Request";

            alert("Something went wrong. Please try again.");

            console.error(error);

        });

    });

}
/*=========================================
CONTACT FORM
=========================================*/

const contactForm = document.getElementById("contactForm");

if(contactForm){

    contactForm.addEventListener("submit", function(e){

        e.preventDefault();

        const submitBtn = document.getElementById("contactSubmit");

        submitBtn.disabled = true;
        submitBtn.innerHTML = "Sending...";

        fetch("ajax/contact-form.php",{
            method:"POST",
            body:new FormData(contactForm)
        })

        .then(response => response.json())

        .then(data=>{

            submitBtn.disabled = false;
            submitBtn.innerHTML = "Send Message";

            if(data.success){

                contactForm.reset();

                const modal = document.getElementById("sellerSuccessModal");

                modal.style.display = "flex";
                document.body.style.overflow = "hidden";

                setTimeout(function(){

                    modal.style.display = "none";
                    document.body.style.overflow = "";

                },4000);

            }else{

                alert(data.message);

            }

        })

        .catch(error=>{

            submitBtn.disabled = false;
            submitBtn.innerHTML = "Send Message";

            console.error(error);

            alert("Something went wrong. Please try again.");

        });

    });

}
/* ==========================================
   Mobile Navigation
========================================== */

const menuToggle = document.getElementById("menuToggle");
const navLinks = document.getElementById("navLinks");

if (menuToggle && navLinks) {

    menuToggle.addEventListener("click", function () {

        navLinks.classList.toggle("active");

        menuToggle.innerHTML = navLinks.classList.contains("active")
            ? "✕"
            : "☰";

    });

    document.querySelectorAll(".nav-links a").forEach(link => {

        link.addEventListener("click", function () {

            navLinks.classList.remove("active");
            menuToggle.innerHTML = "☰";

        });

    });

}