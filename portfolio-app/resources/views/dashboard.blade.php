<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="p-6 text-gray-900">
        {{ __("You're logged in!") }}

        <hr style="margin: 20px 0;">

        <h3><strong>Portfolio Owner Action Tools</strong></h3>
        <p>Use the links below to access your protected application administration views:</p>
        <ul>
            <li><a href="/owner/dashboard" style="color: blue; text-decoration: underline;">Go to Portfolio Control Hub Console</a></li>
            <li><a href="/" style="color: blue; text-decoration: underline;">View Public Frontend Showcase Site</a></li>
        </ul>
    </div>
</x-app-layout>
