<div class="container max-w-7xl">


<x-mary-form wire:submit="save">
        <div class="grid grid-cols-2">
            @foreach($quizQuestions as $question)

             <div class="col-span-2 md:col-span-1" wire:poll="scoreAnswers">
                           
                   
                    @if($scoreAnswers[$question->id] === 1)
                    <p class='text-center text-success text-lg lg:text-xl font-semibold py-2'>Correct</p>
                    @elseif($scoreAnswers[$question->id] === 0)
                    <p class='text-center text-danger text-lg lg:text-xl font-semibold py-2'>Correct</p>
                    @else
                    <p class='text-center text-accent text-lg lg:text-xl font-semibold py-2'>{{ $question->question }}</p>
                    @endif
                
                    <div class="grid grid-cols-2 p-4 gap-2">
                      <div class="grid grid-cols-1 p-4">
                        @foreach($question->options->take(4) as $option)
                            <div class="form-control">
                                <label class="label cursor-pointer">
                                    <span class="label-text">{{ $option->option }}</span>
                                    <input type="radio" wire:model="answers.{{ $question->id }}" value="{{$option->id}}" name="{{$question->id}}" class="radio checked:bg-blue-500" />
                                </label>
                            </div>
                        @endforeach 
                        </div>

                        <div class="grid grid-cols-1 p-4">
                        @foreach($question->options->skip(4)->take(4) as $option)
                            <div class="form-control">
                                <label class="label cursor-pointer">
                                    <span class="label-text">{{ $option->option }}</span>
                                    <input type="radio" value="{{$option->id}}" name="{{$question->id}}" wire:model="answers.{{ $question->id }}" class="radio checked:bg-blue-500" />
                                </label>
                            </div>
                        @endforeach 
                        </div>
                    </div>
                      

            </div>
            @endforeach
            <div class="col-span-2">
            <x-mary-button label="Submit & Grade" class="btn-success btn-block" icon="o-plus" type="submit" spinner="save" />
            </div>
            </x-mary-form>
            
</div>