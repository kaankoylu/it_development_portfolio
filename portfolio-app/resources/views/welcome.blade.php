<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $bio->full_name ?? 'Home' }}</title>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cards_aside.css') }}">
    <link rel="stylesheet" href="{{ asset('css/card_contents.css') }}">

    <!-- i just realised website sometimes slides towards right or left, to limit that i am putting this one here to limit the page only
     to go up or down not right or left -->
    <style>
        html, body {
            max-width: 100%;
            overflow-x: hidden;
            position: relative;
        }
    </style>
</head>

<body>
    <div class="top_bar">
        <div class="main_label" id="label_home">
            <h1>Project Site</h1>
        </div>
        <div class="buttons">
            <button id="profile_button">
                <img src="{{ asset('images/user.png') }}">
            </button>
            <button id="dashboard_button">
                <img src="{{ asset('images/dashboard.png') }}">
            </button>
            <button id="faq_button">
                <img src="{{ asset('images/faq.png') }}">
            </button>
            <button id="blog_button">
                <img src="{{ asset('images/blog.png') }}">
            </button>

            @auth
            <a href="{{ route('owner.dashboard') }}" style="margin-left: 15px; text-decoration: none; font-weight: bold; color: rgba(255, 255, 255, 0.25); font-family: sans-serif; font-size: 14px; vertical-align: middle; transition: color 0.3s ease;" onmouseover="this.style.color='rgba(255, 255, 255, 0.85)'" onmouseout="this.style.color='rgba(255, 255, 255, 0.25)'">Owner Login</a>
            @else
            <a href="{{ route('login') }}" style="margin-left: 15px; text-decoration: none; font-weight: bold; color: #fff; font-family: sans-serif; font-size: 14px; vertical-align: middle;">Login</a>
            <!-- <a href="{{ route('register') }}" style="margin-left: 10px; text-decoration: none; font-weight: bold; color: #fff; font-family: sans-serif; font-size: 14px; vertical-align: middle;">Register</a> -->
            @endauth
        </div>
    </div>

    <aside id="aside_menu">
        <div class="main_subject">
            <img src="{{ asset('images/hz_logo.png') }}">
        </div>
        <ul>
            <li><a target="_blank" href="https://hz.nl">HZ home</a></li>
            <li><a target="_blank" href="https://hz.nl/en/about-hz/organisation/regulations-and-documents#panel1945070">HZ documents</a></li>
            <li><a target="_blank" href="https://learn.hz.nl/">HZ learn</a></li>
            <li><a target="_blank" href="https://hz.osiris-student.nl/">HZ osiris</a></li>
            <li><a target="_blank" href="https://teams.microsoft.com/l/team/19%3a827654897ab746089c081f24aff1c984%40thread.skype/conversations?groupId=337e8cca-f67d-4132-9fa9-b0c761bbeb94&tenantId=4c16deb3-342d-4fca-bcd5-b1429308034c">ICT teams(algeemen)</a></li>
            <li><a target="_blank" href="https://github.com/HZ-HBO-ICT">ICT github</a></li>
        </ul>
    </aside>

    <div class="main_page" id="main_page">
        <div class="main_text">
            <p class="main_subject">Welcome to the website.</p>
            <p>here is the quick informations about structure and content of the site:</p>
            <li>- Conversion complete: Interactive web application driven by Laravel PHP.</li>
            <li>- Total ECs Earned dynamically calculated: <strong>{{ $totalEC }} EC</strong></li>
            <li>- Dynamic database systems: Swapped flat html lists for active model queries.</li>
        </div>
        <div class="list_elements">
            <li class="subject">The meanings of the icons are:</li>
            <li class="list">Profile: Personal information can be found there</li>
            <li class="list">Dashboard: There is a overview of the study.</li>
            <li class="list">faq: Answers for the frequently asked questions.</li>
            <li class="list">Blog: chronogical ordered blog posts.</li>
        </div>
    </div>

    <div style="display:none" class="toggle_content" id="profile_card">
        <div class="container">
            <div class="image">
                <img src="{{ asset('images/profile_photo.png') }}" width="400" height="400">
            </div>

            <div class="characteristics">
                <button id="profile_card_closer" class="close_button"><img src="{{ asset('images/close.png') }}"></button>
                <div class="list">
                    <h2>
                        <h1>Characteristics:</h1>
                    </h2>
                    <ol>
                        <li>
                            <h2>
                                <p>Friendly</p>
                            </h2>
                        </li>
                        <li>
                            <h2>
                                <p>Hardworker</p>
                            </h2>
                        </li>
                        <li>
                            <h2>
                                <p>Creative</p>
                            </h2>
                        </li>
                        <li>
                            <h2>
                                <p>Adaptable</p>
                            </h2>
                        </li>
                    </ol>
                    <p style="margin-top: 15px; font-family: sans-serif; font-size: 14px;"><strong>Core Skills:</strong> {{ $bio->skills }}</p>
                </div>

                <div class="about">
                    <h2>About me ({{ $bio->full_name }} - {{ $bio->title }}):</h2>
                    <p>{{ $bio->bio_text }}</p>
                </div>
            </div>
        </div>
    </div>

    <div style="display: none;" class="toggle_content" id="dashboard_card">
        <button id="dashboard_card_closer" class="close_button"><img src="{{ asset('images/close.png') }}"></button>
        <table border="1">
            <thead>
                <tr>
                    <td>Course</td>
                    <td>EC</td>
                    <td>Status</td>
                    <td>Grade</td>
                    <td class="completion">Completion</td>
                </tr>
            </thead>
            <tbody>
                @foreach($courses as $course)
                <tr>
                    <td>{{ $course->course_name }}</td>
                    <td>{{ $course->credits_ec }}</td>
                    <td>{{ $course->status }}</td>
                    <td><strong>{{ $course->grade ?? 'N/A' }}</strong></td>
                    <td class="completion"><input type="checkbox" {{ $course->status === 'Passed' ? 'checked' : '' }}></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="progress_bar" id="progress_bar" style="height: 20px; width: 0%; transition: width 0.4s ease; margin-top: 15px;"></div>
    </div>

    <div style="display: none;" class="toggle_content" id="faq_card">
        <div class="faq_content">
            <button id="faq_card_closer" class="close_button"><img src="{{ asset('images/close.png') }}"></button>
            <h1>Frequently Asked Questions(FAQ):</h1>
            <ul>
                <li>
                    <div id="question_1" style="cursor: pointer;">
                        <h2>How can you print a document from your laptop at HZ?</h2>
                    </div>
                    <div id="answer_1" style="display: none;" class="answer_content">
                        <p> • Select the following printer for your job: HZ Printer</p>
                        <p> • When the print job is given, log in using the HZ pass or by entering your HZ username & password.</p>
                        <p> • Then choose the Print Release option. You will then see which print jobs are ready. If there is sufficient balance in your print account, the print jobs will be printed. Tap Access Device to see your balance. After printing, tap the following icon on the printer to log out:</p>
                    </div>
                </li>
                <li>
                    <div id="question_2" style="cursor: pointer;">
                        <h2>How can you scan a document and send it to your laptop at HZ?</h2>
                    </div>
                    <div id="answer_2" style="display: none;" class="answer_content">
                        <p>• Log on to the printer using your HZ card or by entering your HZ user name & password.</p>
                        <p>• Choose the Scan option in the menu.</p>
                        <p>• Place the original(s) on the feeder or glass plate.</p>
                        <p> Double-sided scanning (optional)</p>
                        <p>• Press Change settings</p>
                        <p>• For duplex mode, select the 2-sided option</p>
                        <p>• Press Start</p>
                        <p>• After scanning, press the following symbol on the printer to log off:</p>
                    </div>
                </li>
                <li>
                    <div id="question_3" style="cursor: pointer;">
                        <h2>How can I buy something (like when I sign up for the IT introduction event) on the HZ web shop?</h2>
                    </div>
                    <div id="answer_3" style="display: none;" class="answer_content">
                        <p>you can buy it from, <a target="_blank" href="https://webshop.hz.nl/webshopapp/defaulten.aspx?menu=082076044027019251066025111065201099237062130097">here</a></p>
                    </div>
                </li>
                <li>
                    <div id="question_4" style="cursor: pointer;">
                        <h2>How can you book a project space in one of the wings?</h2>
                    </div>
                    <div id="answer_4" style="display: none;" class="answer_content">
                        <p>it can easily booked from <a target="_blank" href="https://hzuniversity.topdesk.net/tas/public/ssp/content/detail/service?unid=7e54d40b762c4dc79205e200f0d4d818">here</a></p>
                    </div>
                </li>
                <li>
                    <div id="question_5" style="cursor: pointer;">
                        <h2>What are the instructions if you want to park your car at the HZ parking lot?</h2>
                    </div>
                    <div id="answer_5" style="display: none;" class="answer_content">
                        <p>At the barrier of the car park the Poelendaelesingel you can ring the bell. After passing the barrier, follow the signs to the HZ parking places, marked with a white sign with the HZ logo.</p>
                        <p>if student or staff: enter by presenting HZ pass at the barriers, guests can ring the bell at the barrier.</p>
                    </div>
                </li>
            </ul>

            <div class="api-monitor-section" style="margin-top: 35px; padding: 15px; background: rgba(255,255,255,0.08); border-radius: 6px; font-family: sans-serif;">
                <h3 style="color: #fff; margin-bottom: 10px; font-size: 16px;">Dynamic API Live Integration Monitor</h3>
                <button id="loadApiBtn" style="background: #fff; color: #000; border: none; padding: 8px 12px; font-weight: bold; cursor: pointer; border-radius: 4px;">Query Live Portfolio APIs via Fetch()</button>

                <div id="apiResponseArea" style="margin-top: 15px; font-family: monospace; background: #222; color: #0f0; padding: 10px; display: none; border-radius: 4px; text-align: left;">
                    <h4 style="color: #fff; margin: 5px 0;">Endpoint 1: /api/v1/stats Output</h4>
                    <pre id="statsOutput" style="white-space: pre-wrap; font-size: 12px; margin-bottom: 10px;"></pre>

                    <h4 style="color: #fff; margin: 5px 0;">Endpoint 2: /api/v1/profile Output</h4>
                    <pre id="profileOutput" style="white-space: pre-wrap; font-size: 12px;"></pre>
                </div>
            </div>
        </div>
    </div>

    <div style="display: none;" class="toggle_content" id="blog_card">
        <button id="blog_card_closer" class="close_button"><img src="{{ asset('images/close.png') }}"></button>

        @foreach($posts as $post)
        <div class="post">
            <h2>{{ $post->title }}</h2>
            <button class="read_more dynamic-blog-trigger">read more</button>
            <div style="display: none;" class="post_content">
                <p>{{ $post->content }}</p>
            </div>
            <div class="post_date">Published on: {{ $post->created_at->format('F d, Y') }}</div>
        </div>
        @endforeach
    </div>

    <script>
        /*****************************************
         * 1. INDEX.JS MIXED FROM THE OLD CODE AND MY NEW IMPROVMENTS
         *****************************************/
        const profile_button = document.getElementById("profile_button");
        const dashboard_button = document.getElementById("dashboard_button");
        const faq_button = document.getElementById("faq_button");
        const blog_button = document.getElementById("blog_button");

        function createElement(element, id) {
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

                if (profile.classList.contains("active") || dashboard.classList.contains("active") || faq.classList.contains("active") || blog.classList.contains("active")) {
                    document.getElementById("aside_menu").style.display = "none";
                    document.getElementById("main_page").style.display = "none";
                } else {
                    document.getElementById("aside_menu").style.display = "block";
                    document.getElementById("main_page").style.display = "block";
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
            document.getElementById(`${cardName}_card_closer`).addEventListener("click", () => {
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
            if (checkboxes.length === 0) return;
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
        document.getElementById('loadApiBtn').addEventListener('click', function() {
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
    </script>
</body>

</html>
