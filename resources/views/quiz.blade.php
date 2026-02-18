<x-app-layout>
<x-slot name="header">
<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
Hello, {{ ucwords(Auth::user()->name) }}
</h2>

<ul class="right my-2">
    <li>
        <a class="btn btn-sm btn-primary" href="{{ route('betslip.create') }}">
            Bet Tracker
        </a>
    </li>
</ul>
</x-slot>
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    
    <livewire:quiz-mob :quiz="$quiz" />
    </div>
    </x-app-layout>