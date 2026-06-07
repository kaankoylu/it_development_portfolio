<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Owner Dashboard</title>
</head>
<body>
    <h1>Portfolio Control Console</h1>
    <a href="{{ route('portfolio.index') }}">← Back to Public Site</a>
    <hr>

    @if ($errors->any())
        <div style="background-color: #ffcccc; padding: 10px; border: 1px solid red;">
            <strong>Input Error Alerts:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <p style="color: green;"><strong>Success: {{ session('success') }}</strong></p>
    @endif

    <section>
        <h3>Manage Biographical Information</h3>
        <form action="{{ route('owner.bio.update') }}" method="POST">
            @csrf
            <label>Full Name: <input type="text" name="full_name" value="{{ $bio->full_name ?? '' }}"></label><br><br>
            <label>Professional Title: <input type="text" name="title" value="{{ $bio->title ?? '' }}"></label><br><br>
            <label>Bio Profile:<br> <textarea name="bio_text" rows="4">{{ $bio->bio_text ?? '' }}</textarea></label><br><br>
            <label>Skills (Comma-separated): <input type="text" name="skills" value="{{ $bio->skills ?? '' }}"></label><br><br>
            <button type="submit">Save Profile Changes</button>
        </form>
    </section>
    <hr>

    <section>
        <h3>Track New Course Progress</h3>
        <form action="{{ route('owner.course.store') }}" method="POST">
            @csrf
            <label>Course Name: <input type="text" name="course_name" required></label><br><br>
            <label>Credits (EC): <input type="number" name="credits_ec" min="1" required></label><br><br>
            <label>Status:
                <select name="status">
                    <option value="not_started">Not Started</option>
                    <option value="in_progress">In Progress</option>
                    <option value="completed">Completed</option>
                </select>
            </label><br><br>
            <label>Grade: <input type="number" name="grade" step="0.1" min="1" max="10"></label><br><br>
            <button type="submit">Log Course Data</button>
        </form>
    </section>
    <hr>

    <section>
        <h3>Publish New Article</h3>
        <form action="{{ route('owner.post.store') }}" method="POST">
            @csrf
            <label>Title: <input type="text" name="title" required></label><br><br>
            <label>Content:<br> <textarea name="content" rows="5" required></textarea></label><br><br>
            <label>Initial Phase:
                <select name="status">
                    <option value="draft">Draft</option>
                    <option value="review">Under Review</option>
                    <option value="published">Published</option>
                </select>
            </label><br><br>
            <button type="submit">Create Post</button>
        </form>
    </section>
    <hr>

    <section>
        <h3>Active Blog Workflows</h3>
        <ul>
            @foreach($posts as $post)
                <li>
                    <strong>{{ $post->title }}</strong> (Current Status: <em>{{ $post->status }}</em>)
                    <form action="{{ route('owner.post.update', $post) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <select name="status">
                            <option value="draft" {{ $post->status == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="review" {{ $post->status == 'review' ? 'selected' : '' }}>Review</option>
                            <option value="published" {{ $post->status == 'published' ? 'selected' : '' }}>Publish</option>
                        </select>
                        <button type="submit">Update State</button>
                    </form>
                </li>
            @endforeach
        </ul>
    </section>
</body>
</html>
