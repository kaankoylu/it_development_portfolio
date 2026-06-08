<div class="top_bar">
    <div class="main_label" id="label_home">
        <h1><a href="/" style="color: inherit; text-decoration: none;">Project Site</a></h1>
    </div>
    <div class="buttons" style="display: flex; align-items: center;">
        @if(Request::is('owner/dashboard') || Request::is('login'))
            <a href="/" style="text-decoration: none; font-weight: bold; color: #fff; font-family: sans-serif; font-size: 14px; vertical-align: middle; transition: opacity 0.3s;" onmouseover="this.style.opacity='0.7'" onmouseout="this.style.opacity='1'">
                Back to Public View
            </a>
            @if(Request::is('owner/dashboard'))
                <form action="{{ route('logout') }}" method="POST" style="display: inline; margin-left: 20px;">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: #fff; cursor: pointer; font-weight: bold; font-family: sans-serif; font-size: 14px; vertical-align: middle; transition: opacity 0.3s;" onmouseover="this.style.opacity='0.7'" onmouseout="this.style.opacity='1'">
                        Logout
                    </button>
                </form>
            @endif
        @else
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
            @endauth
        @endif
    </div>
</div>
