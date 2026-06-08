@extends('layouts.app')

@section('title', 'Owner Dashboard - Control Console')

@section('styles')
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
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 12px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            border-left: 4px solid gold;
        }

        @media (min-width: 768px) {
            .workflow-item {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }
        }

        .workflow-details {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .workflow-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-danger {
            background: #ff4d4d;
            color: #fff;
            border: none;
            padding: 6px 12px;
            font-size: 12px;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-danger:hover {
            background: #ff3333;
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
    </style>
@endsection

@section('content')
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

            <form action="{{ route('owner.posts.bulkUpdate') }}" method="POST">
                @csrf
                @method('PATCH')

                <div style="margin-top: 15px; margin-bottom: 20px;">
                    @foreach($posts as $post)
                    <div class="workflow-item">
                        <div class="workflow-details">
                            <div style="display: flex; gap: 10px; width: 100%;">
                                <input type="text" name="posts[{{ $post->id }}][title]" class="form-control" value="{{ $post->title }}" style="font-weight: bold;" required>
                            </div>
                            <div style="width: 100%;">
                                <textarea name="posts[{{ $post->id }}][content]" class="form-control" rows="2" style="font-size: 13px;" required>{{ $post->content }}</textarea>
                            </div>
                        </div>

                        <div class="workflow-actions">
                            <select name="posts[{{ $post->id }}][status]" class="form-control" style="width: auto; padding: 5px 10px; height: 38px;">
                                <option value="draft" {{ $post->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="review" {{ $post->status == 'review' ? 'selected' : '' }}>Review</option>
                                <option value="published" {{ $post->status == 'published' ? 'selected' : '' }}>Publish</option>
                            </select>

                            <button type="button" class="btn-danger" onclick="if(confirm('Are you sure you want to delete this post?')) { document.getElementById('delete-form-{{ $post->id }}').submit(); }">
                                Delete
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>

                @if($posts->count() > 0)
                    <button type="submit" class="btn-submit" style="background: #fff; color: #000; border: 1px solid #ccc;">
                        Update All Posts Content & States
                    </button>
                @endif
            </form>

            @foreach($posts as $post)
                <form id="delete-form-{{ $post->id }}" action="{{ route('owner.post.destroy', $post) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            @endforeach
        </div>
    </div>
@endsection
