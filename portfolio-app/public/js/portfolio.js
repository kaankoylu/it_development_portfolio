/*****************************************
 * 1. INDEX.JS MIXED FROM THE OLD CODE AND MY NEW IMPROVMENTS
 *****************************************/
const profile_button = document.getElementById("profile_button");
const dashboard_button = document.getElementById("dashboard_button");
const faq_button = document.getElementById("faq_button");
const blog_button = document.getElementById("blog_button");

function createElement(element, id) {
    if (!element) return;
    element.addEventListener("click", () => {
        let card = document.getElementById(id);
        card.classList.toggle("active");
        if (card.classList.contains("active")) {
            showHidden(card);
            hideAside(card);
        } else {
            hideElement(card);
            hideAside(card);
        }
    });
}

createElement(profile_button, 'profile_card');
createElement(dashboard_button, 'dashboard_card');
createElement(faq_button, 'faq_card');
createElement(blog_button, 'blog_card');

function showHidden(element) {
    element.style.display = "block";
}

function hideElement(element) {
    element.style.display = "none";
}

function hideAside(element) {
    if (element.classList.contains("active")) {
        document.getElementById("aside_menu").style.display = "none";
        document.getElementById("main_page").style.display = "none";
    } else {
        let profile = document.getElementById("profile_card");
        let dashboard = document.getElementById("dashboard_card");
        let faq = document.getElementById("faq_card");
        let blog = document.getElementById("blog_card");

        if ((profile && profile.classList.contains("active")) ||
            (dashboard && dashboard.classList.contains("active")) ||
            (faq && faq.classList.contains("active")) ||
            (blog && blog.classList.contains("active"))) {
            document.getElementById("aside_menu").style.display = "none";
            document.getElementById("main_page").style.display = "none";
        } else {
            if (document.getElementById("aside_menu")) document.getElementById("aside_menu").style.display = "block";
            if (document.getElementById("main_page")) document.getElementById("main_page").style.display = "block";
        }
    }
}

/*****************************************
 * 2. CARD_SCRIPTS.JS LOGIC ALSO IMPORVED FROM OLD PROJECT
 *****************************************/
closerButton('profile');
closerButton('dashboard');
closerButton('faq');
closerButton('blog');

function closerButton(cardName) {
    const closerEl = document.getElementById(`${cardName}_card_closer`);
    if (!closerEl) return;
    closerEl.addEventListener("click", () => {
        let card = document.getElementById(`${cardName}_card`);
        card.classList.remove("active");
        card.style.display = "none";
        hideAside(card);
    });
}

// DASHBOARD PROGRESS BAR MANAGEMENT
const checkboxes = document.querySelectorAll(".completion input[type='checkbox']");
const progressBar = document.getElementById("progress_bar");
let checkedCount = document.querySelectorAll(".completion input[type='checkbox']:checked").length;

// Initial load configuration call
updateProgressBar();

checkboxes.forEach(checkbox => {
    checkbox.addEventListener("change", function() {
        if (this.checked) {
            checkedCount++;
        } else {
            checkedCount--;
        }
        updateProgressBar();
    });
});

function updateProgressBar() {
    if (checkboxes.length === 0 || !progressBar) return;
    const percentCalculation = (checkedCount / checkboxes.length) * 100;
    progressBar.style.width = percentCalculation + "%";
    if (percentCalculation <= 25) {
        progressBar.style.backgroundColor = "black";
    } else if (percentCalculation <= 50) {
        progressBar.style.backgroundColor = "red";
    } else if (percentCalculation <= 75) {
        progressBar.style.background = "orange";
    } else {
        progressBar.style.backgroundColor = "green";
    }
}

// DYNAMIC FAQ INTERACTION ACCORDIONS
for (let i = 1; i <= 5; i++) {
    const questionElement = document.getElementById(`question_${i}`);
    if (questionElement) {
        questionElement.addEventListener("click", () => {
            let answer = document.getElementById(`answer_${i}`);
            answer.classList.toggle("active");
            answer.style.display = answer.classList.contains("active") ? "block" : "none";
        });
    }
}

// DYNAMIC BLOG READ MORE HANDLER
document.querySelectorAll('.dynamic-blog-trigger').forEach(btn => {
    btn.addEventListener('click', function() {
        const contentBlock = this.nextElementSibling;
        contentBlock.classList.toggle("active");
        contentBlock.style.display = contentBlock.classList.contains("active") ? "block" : "none";
    });
});

/*****************************************
 * 3. CLIENT-SIDE API FETCH IMPLEMENTATION  ******* CURRENTLY UNDER TEST NOT DONE YET ********
 *****************************************/
const apiBtn = document.getElementById('loadApiBtn');
if (apiBtn) {
    apiBtn.addEventListener('click', function() {
        const outputArea = document.getElementById('apiResponseArea');
        outputArea.style.display = 'block';

        fetch('/api/v1/stats')
            .then(response => response.json())
            .then(data => {
                document.getElementById('statsOutput').textContent = JSON.stringify(data, null, 2);
            })
            .catch(err => console.error('Error fetching stats api:', err));

        fetch('/api/v1/profile')
            .then(response => response.json())
            .then(data => {
                document.getElementById('profileOutput').textContent = JSON.stringify(data, null, 2);
            })
            .catch(err => console.error('Error fetching profile api:', err));
    });
}
