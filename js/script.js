document.addEventListener("DOMContentLoaded", () => {
    const typewriterElement = document.getElementById("typewriter-container");
    
    if (typewriterElement) {
        // Break down the text and HTML tags into an array sequence
        const tokens = [
            ..."Sell Your Mobile Home",
            "<br>",
            ..."Fast for ",
            "<span>", 
            ..."Cash", 
            "</span>"
        ];
        
        let i = 0;
        let currentText = "";
        
        function type() {
            if (i < tokens.length) {
                currentText += tokens[i];
                
                // Update the text and keep the cursor at the very end
                typewriterElement.innerHTML = currentText + '<span class="cursor">|</span>';
                i++;
                
                // If the token is an HTML tag (length > 1), type it instantly (0ms). 
                // Otherwise, add a natural typing delay (40ms - 90ms).
                const isTag = tokens[i - 1].length > 1;
                const typingSpeed = isTag ? 0 : Math.random() * 50 + 40;
                
                setTimeout(type, typingSpeed);
            }
        }
        
        // Start the animation with a slight 500ms delay after page load
        setTimeout(type, 500);
    }
});
const cards = document.querySelectorAll(".step-card");

const observer = new IntersectionObserver((entries)=>{

    entries.forEach(entry=>{

        if(entry.isIntersecting){

            const index = [...cards].indexOf(entry.target);

            setTimeout(()=>{

                entry.target.classList.add("show");

            }, index * 180);

        }

    });

},{
    threshold:.25
});

cards.forEach(card=>observer.observe(card));