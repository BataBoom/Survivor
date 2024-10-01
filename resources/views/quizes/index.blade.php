<x-app-layout>

 <x-slot:header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Quizes') }}
      </h2>
 </x-slot:header>


<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">


<div class="overflow-x-auto">
  <table class="table max-w-full">
            <!-- head -->
            <h1 class="py-2 underline underline-offset-y-4 text-sm italic text-gray-800">My Quiz Scores</h1>
        
        <ul class="right flex justify-between">
            <li>
                <a href="#" class="btn btn-primary btn-sm" disabled>Export</a>
            </li>
        </ul>
            <thead>
            <tr>
                
                <th>Quiz</th>
                <th>Score (%)</th>
                <th>Started</th>
                <th>Last Attempt</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <!-- row 1 -->
            @forelse($quizes as $quiz)
            <tr class="hover">
                
                <td class="text-sm text-left">
                    {{$quiz->quiz->name}}
                </td>

                <td class="text-sm text-left">
                     {{$quiz->percentage}}%
                </td>
                <td class="text-sm text-left">
                    {{ $quiz->created_at->diffForHumans() }}
                </td>
                <td class="text-sm text-left">
                     {{ $quiz->updated_at->diffForHumans() }}
                </td>
                <td class="flex justify-between flex-col">
                    <a href="{{ route('quiz.show', ['quiz' => $quiz->quiz->slug]) }}" class="btn btn-success btn-sm my-2">Retry</a>
                </td>
               
            </tr>
            @empty
            @endforelse
            </tbody>
            <!-- foot -->
            <tfoot>
            <tr>
                <th>Quiz</th>
                <th>Score (%)</th>
                <th>Started</th>
                <th>Last Attempt</th>
                <th>Actions</th>

            </tr>
            </tfoot>

        </table>

        {{ $quizes->links() }}
  </div>
</div>

</x-app-layout>