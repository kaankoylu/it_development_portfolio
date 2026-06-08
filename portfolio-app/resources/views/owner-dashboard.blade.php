<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Dashboard - Control Console</title>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cards_aside.css') }}">
    <link rel="stylesheet" href="{{ asset('css/card_contents.css') }}">
    <style>
        .main_page {
            margin-left: auto !important;
            margin-right: auto !important;
            width: calc(100% - 100px) !important;
            max-width: 1200px;
            padding-top: 30px;
        }


        .admin-card {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            color: #fff;
        }

        .admin-card h3 {
            font-size: 20px;
            margin-bottom: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding-bottom: 8px;
            color: gold;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 14px;
            color: #ddd;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            background: rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 4px;
            color: #fff;
            font-size: 14px;
            box-sizing: border-box;
        }

        .form-control:focus {
            border-color: gold;
            outline: none;
        }

        .btn-submit {
            background: gold;
            color: #111;
            border: none;
            padding: 10px 20px;
            font-weight: bold;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn-submit:hover {
            background: #fff;
        }

        .workflow-item {
            background: rgba(0, 0, 0, 0.3);
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-left: 4px solid gold;
        }

        .alert-error {
            background-color: rgba(255, 0, 0, 0.2);
            border: 1px solid red;
            color: #ffcccc;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: rgba(0, 255, 0, 0.2);
            border: 1px solid green;
            color: #ccffcc;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }


        /* i just realised website sometimes slides towards right or left, to limit that i am putting this one here to limit the page only
        to go up or down not right or left */
        html,
        body {
            max-width: 100%;
            overflow-x: hidden;
            position: relative;
        }
    </style>

</head>

<body>
    <div class="top_bar">
        <div class="main_label" id="label_home">
            <h1><a href="/" style="color: inherit; text-decoration: none;">Project Site</a></h1>
        </div>
        <div class="buttons" style="display: flex; align-items: center;">
            <a href="/" style="text-decoration: none; font-weight: bold; color: #fff; font-family: sans-serif; font-size: 14px; vertical-align: middle; transition: opacity 0.3s;" onmouseover="this.style.opacity='0.7'" onmouseout="this.style.opacity='1'">
                Back to Public View
            </a>

            <form action="{{ route('logout') }}" method="POST" style="display: inline; margin-left: 20px;">
                @csrf
                <button type="submit" style="background: none; border: none; color: #fff; cursor: pointer; font-weight: bold; font-family: sans-serif; font-size: 14px; vertical-align: middle; transition: opacity 0.3s;" onmouseover="this.style.opacity='0.7'" onmouseout="this.style.opacity='1'">
                    Logout
                </button>
            </form>
        </div>
    </div>

    <div class="main_page" id="main_page">
        <div class="main_text" style="margin-bottom: 30px;">
            <p class="main_subject">Portfolio Control Console</p>
            <p>Welcome back, system owner. Use the operational cards below to directly manage database models live on the production site.</p>
        </div>

        @if ($errors->any())
        <div class="alert-error">
            <strong>Input Error Alerts:</strong>
            <ul style="margin-top: 5px; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if(session('success'))
        <div class="alert-success">
            <strong>Success:</strong> {{ session('success') }}
        </div>
        @endif

        <div class="admin-card">
            <h3>Manage Biographical Information</h3>
            <form action="{{ route('owner.bio.update') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="full_name" class="form-control" value="{{ $bio->full_name ?? '' }}">
                </div>
                <div class="form-group">
                    <label>Professional Title</label>
                    <input type="text" name="title" class="form-control" value="{{ $bio->title ?? '' }}">
                </div>
                <div class="form-group">
                    <label>Bio Profile Summary</label>
                    <textarea name="bio_text" class="form-control" rows="4">{{ $bio->bio_text ?? '' }}</textarea>
                </div>
                <div class="form-group">
                    <label>Skills (Comma-separated string)</label>
                    <input type="text" name="skills" class="form-control" value="{{ $bio->skills ?? '' }}">
                </div>
                <button type="submit" class="btn-submit">Save Profile Changes</button>
            </form>
        </div>

        <div class="admin-card">
            <h3>Track New Course Progress</h3>
            <form action="{{ route('owner.course.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Course Name</label>
                    <input type="text" name="course_name" class="form-control" required>
                </div>
                <div class="form-group" style="display: flex; gap: 15px;">
                    <div style="flex: 1;">
                        <label>Credits (EC)</label>
                        <input type="number" name="credits_ec" class="form-control" min="1" required>
                    </div>
                    <div style="flex: 1;">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="not_started">Not Started</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                    <div style="flex: 1;">
                        <label>Grade</label>
                        <input type="number" name="grade" class="form-control" step="0.1" min="1" max="10">
                    </div>
                </div>
                <button type="submit" class="btn-submit">Log Course Data</button>
            </form>
        </div>

        <div class="admin-card">
            <h3>Publish New Article</h3>
            <form action="{{ route('owner.post.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Content Payload</label>
                    <textarea name="content" class="form-control" rows="5" required></textarea>
                </div>
                <div class="form-group">
                    <label>Initial Phase</label>
                    <select name="status" class="form-control">
                        <option value="draft">Draft</option>
                        <option value="review">Under Review</option>
                        <option value="published">Published</option>
                    </select>
                </div>
                <button type="submit" class="btn-submit">Create Post</button>
            </form>
        </div>

        <div class="admin-card">
            <h3>Active Blog Workflows</h3>
            <div style="margin-top: 15px;">
                @foreach($posts as $post)
                <div class="workflow-item">
                    <div>
                        <strong style="color: #fff; font-size: 15px;">{{ $post->title }}</strong>
                        <span style="color: #aaa; font-size: 12px; margin-left: 10px;">(Status: <em style="color: gold;">{{ $post->status }}</em>)</span>
                    </div>
                    <form action="{{ route('owner.post.update', $post) }}" method="POST" style="display: flex; gap: 8px; align-items: center;">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="form-control" style="width: auto; padding: 5px 10px; height: 32px;">
                            <option value="draft" {{ $post->status == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="review" {{ $post->status == 'review' ? 'selected' : '' }}>Review</option>
                            <option value="published" {{ $post->status == 'published' ? 'selected' : '' }}>Publish</option>
                        </select>
                        <button type="submit" class="btn-submit" style="padding: 5px 12px; height: 32px; font-size: 12px;">Update State</button>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</body>

</html>
