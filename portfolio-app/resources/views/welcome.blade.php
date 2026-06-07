<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $bio->full_name }} - Portfolio Showcase</title>
</head>
<body>
    <nav>
        <a href="{{ route('login') }}">Owner Login</a> |
        <a href="{{ route('register') }}">Register</a>
    </nav>
    <hr>

    <header>
        <h1>{{ $bio->full_name }}</h1>
        <h2>{{ $bio->title }}</h2>
        <p><strong>Total ECs Earned:</strong> {{ $totalEC }} EC</p>
    </header>
    <hr>

    <section>
        <h3>About Me</h3>
        <p>{{ $bio->bio_text }}</p>
        <p><strong>Core Skills:</strong> {{ $bio->skills }}</p>
    </section>
    <hr>

    <section>
        <h3>Academic Progress Track</h3>
        <table border="1">
            <thead>
                <tr>
                    <th>Course</th>
                    <th>ECs</th>
                    <th>Status</th>
                    <th>Grade</th>
                </tr>
            </thead>
            <tbody>
                @foreach($courses as $course)
                <tr>
                    <td>{{ $course->course_name }}</td>
                    <td>{{ $course->credits_ec }}</td>
                    <td>{{ $course->status }}</td>
                    <td>{{ $course->grade ?? 'N/A' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>
    <hr>

    <section>
        <h3>Blog Updates</h3>
        @foreach($posts as $post)
            <article>
                <h4>{{ $post->title }}</h4>
                <small>Published on: {{ $post->created_at->format('Y-m-d') }}</small>
                <p>{{ $post->content }}</p>
            </article>
            <hr>
        @endforeach
    </section>

    <section>
        <hr>
    <section>
        <h3>Dynamic API Live Integration Monitor</h3>
        <button id="loadApiBtn">Query Live Portfolio APIs via Fetch()</button>

        <div id="apiResponseArea" style="margin-top: 15px; font-family: monospace; background: #eee; padding: 10px; display: none;">
            <h4>Endpoint 1: /api/v1/stats Output</h4>
            <pre id="statsOutput"></pre>

            <h4>Endpoint 2: /api/v1/profile Output</h4>
            <pre id="profileOutput"></pre>
        </div>
    </section>

    <script>
        document.getElementById('loadApiBtn').addEventListener('click', function() {
            const outputArea = document.getElementById('apiResponseArea');
            outputArea.style.display = 'block';

            //API realted
            fetch('/api/v1/stats')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('statsOutput').textContent = JSON.stringify(data, null, 2);
                })
                .catch(err => console.error('Error hitting stats api:', err));

            // API related 2
            fetch('/api/v1/profile')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('profileOutput').textContent = JSON.stringify(data, null, 2);
                })
                .catch(err => console.error('Error hitting profile api:', err));
        });
    </script>
    </section>



</body>
</html>
