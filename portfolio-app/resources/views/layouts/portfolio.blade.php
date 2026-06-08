<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Portfolio Showcase' }}</title>

    <!-- Laravel asset helpers to connect to css files pulled from old project -->
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cards_aside.css') }}">
    <link rel="stylesheet" href="{{ asset('css/card_contents.css') }}">
</head>
<body>

    <!-- GLOBAL TOP BAR -->
    <div class="top_bar">
        <div class="main_label" id="label_home">
            <h1><a href="/" style="color: inherit; text-decoration: none;">Project Site</a></h1>
        </div>
        <div class="buttons">
            <a href="/#profile" id="profile_button" class="nav-btn"><img src="{{ asset('images/user.png') }}"></a>
            <a href="/#dashboard" id="dashboard_button" class="nav-btn"><img src="{{ asset('images/dashboard.png') }}"></a>
            <a href="/#faq" id="faq_button" class="nav-btn"><img src="{{ asset('images/faq.png') }}"></a>
            <a href="/#blog" id="blog_button" class="nav-btn"><img src="{{ asset('images/blog.png') }}"></a>

            @auth
                <a href="{{ route('owner.dashboard') }}" style="margin-left: 15px; font-weight: bold; color: gold; text-decoration: none;">Admin Workspace</a>
                <form action="{{ route('logout') }}" method="POST" style="display: inline; margin-left: 10px;">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: white; cursor: pointer; font-weight: bold;">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" style="margin-left: 15px; font-weight: bold; color: white; text-decoration: none;">Login</a>
            @endauth
        </div>
    </div>

    <!-- GLOBAL SIDEBAR -->
    <aside id="aside_menu">
        <div class="main_subject">
            <img src="{{ asset('images/hz_logo.png') }}">
        </div>
        <ul>
            <li><a target="_blank" href="https://hz.nl">HZ home</a></li>
            <li><a target="_blank" href="https://hz.nl/en/about-hz/organisation/regulations-and-documents#panel1945070">HZ documents</a></li>
            <li><a target="_blank" href="https://learn.hz.nl/">HZ learn</a></li>
            <li><a target="_blank" href="https://hz.osiris-student.nl/">HZ osiris</a></li>
            <li><a target="_blank" href="https://teams.microsoft.com/l/team/19%3a827654897ab746089c081f24aff1c984%40thread.skype/conversations?groupId=337e8cca-f67d-4132-9fa9-b0c761bbeb94&tenantId=4c16deb3-342d-4fca-bcd5-b1429308034c">ICT teams</a></li>
            <li><a target="_blank" href="https://github.com/HZ-HBO-ICT">ICT github</a></li>
        </ul>
    </aside>

    <!-- UNIQUE PAGE CONTENT FOR ADDING THE REALTED PAGE IS INDIVIDYAL THINGS -->
    {{ $slot }}

</body>
</html>
