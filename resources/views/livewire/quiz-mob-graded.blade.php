

<div class='text-center text-primary text-xl'>
You Graded {{$percent}}

<a class="btn btn-success btn-block my-1" href="{{ route('quiz.show', ['quiz' => $quiz->slug]) }}">Try Again</a>
<a class="btn btn-primary btn-block my-1" href="{{ route('quiz.index') }}">More Quizes</a>

<h1 class="block text-red-500">Wrong Answers:</h1>


<ul class="p-4">
	@forelse($wrongAnswers as $wa) 
	<li class='block flex flex-col'>
	<p class="text-secondary text-base md:text-xs">{{ $wa[0] }}</p>
	<p class="text-red-500 font-bold  text-base md:text-sm">Pick: {{$wa[1] ?? 'Empty'}} </p>
	</li>
	@empty
	<li class="block text-success">No Wrong Answers!</li>
	@endforelse
</ul>


</div>