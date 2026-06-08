<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Login</title>

    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cards_aside.css') }}">
    <link rel="stylesheet" href="{{ asset('css/card_contents.css') }}">

    <style>
        html,
        body {
            max-width: 100%;
            overflow-x: hidden;
            position: relative;
        }


        .login-center-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 120px);
            padding: 20px;
            box-sizing: border-box;
        }

        .login-card {
            background: rgba(0, 0, 0, 0.6) !important;
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            width: 100%;
            max-width: 400px;
            padding: 35px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
        }

        .login-card h2 {
            color: #fff;
            font-size: 24px;
            margin-bottom: 25px;
            text-align: center;
            font-family: sans-serif;
            letter-spacing: 0.5px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            color: #ccc;
            font-size: 14px;
            margin-bottom: 6px;
            font-family: sans-serif;
        }


        .login-input {
            width: 100%;
            padding: 12px;
            background: rgba(255, 255, 255, 0.08) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            border-radius: 6px;
            color: #fff !important;
            font-size: 14px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        .login-input:focus {
            border-color: #fff !important;
            outline: none;
        }

        .remember-me-group {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            color: #aaa;
            font-size: 13px;
            font-family: sans-serif;
            cursor: pointer;
        }

        .remember-me-group input {
            margin-right: 8px;
            cursor: pointer;
        }

        .login-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .login-submit-btn {
            background: #fff;
            color: #000;
            border: none;
            padding: 10px 24px;
            font-weight: bold;
            font-size: 14px;
            border-radius: 6px;
            cursor: pointer;
            transition: opacity 0.2s;
            font-family: sans-serif;
        }

        .login-submit-btn:hover {
            opacity: 0.85;
        }

        .forgot-link {
            color: #888;
            font-size: 13px;
            text-decoration: none;
            font-family: sans-serif;
            transition: color 0.2s;
        }

        .forgot-link:hover {
            color: #fff;
            text-decoration: underline;
        }

        .error-msg {
            color: #ff6b6b;
            font-size: 12px;
            margin-top: 5px;
            font-family: sans-serif;
        }
    </style>
</head>

<body>
    <div class="top_bar">
        <div class="main_label" id="label_home">
            <h1>Project Site</h1>
        </div>
        <div class="buttons">
            <button id="profile_button" onclick="window.location.href='/#profile'">
                <img src="{{ asset('images/user.png') }}">
            </button>
            <button id="dashboard_button" onclick="window.location.href='/#dashboard'">
                <img src="{{ asset('images/dashboard.png') }}">
            </button>
            <button id="faq_button" onclick="window.location.href='/#faq'">
                <img src="{{ asset('images/faq.png') }}">
            </button>
            <button id="blog_button" onclick="window.location.href='/#blog'">
                <img src="{{ asset('images/blog.png') }}">
            </button>

            @auth
            <a href="{{ route('owner.dashboard') }}" style="margin-left: 15px; text-decoration: none; font-weight: bold; color: rgba(255, 255, 255, 0.25); font-family: sans-serif; font-size: 14px; vertical-align: middle; transition: color 0.3s ease;" onmouseover="this.style.color='rgba(255, 255, 255, 0.85)'" onmouseout="this.style.color='rgba(255, 255, 255, 0.25)'">Owner Login</a>
            @else
            <a href="{{ route('login') }}" style="margin-left: 15px; text-decoration: none; font-weight: bold; color: #fff; font-family: sans-serif; font-size: 14px; vertical-align: middle;">Login</a>
            @endauth
        </div>
    </div>


    <div class="login-center-wrapper">
        <div class="login-card">
            <h2>Sign In</h2>


            <x-auth-session-status class="mb-4" :status="session('status')" style="color: #66bb6a; font-family: sans-serif; font-size: 14px; margin-bottom: 15px;" />

            <form method="POST" action="{{ route('login') }}">
                @csrf


                <div class="input-group">
                    <label for="email">Email Address</label>
                    <input id="email" class="login-input" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="error-msg" />
                </div>


                <div class="input-group">
                    <label for="password">Password</label>
                    <input id="password" class="login-input" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="error-msg" />
                </div>


                <label for="remember_me" class="remember-me-group">
                    <input id="remember_me" type="checkbox" name="remember">
                    <span>Remember me</span>
                </label>


                <div class="login-actions">
                    @if (Route::has('password.request'))
                    <a class="forgot-link" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                    @else
                    <div></div>
                    @endif

                    <button type="submit" class="login-submit-btn">
                        Log In
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
