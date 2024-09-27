<x-app-layout>

 <x-slot:header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Bet Tracker') }}
      </h2>

      <ul class="right">
        <li>
             <a href="{{ route('betslip.create') }}" class="btn btn-success btn-sm my-2">Create</a>
        </li>
      </ul>
 </x-slot:header>


<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

    <div class="grid grid-cols-2 lg:gap-4">
        

 <div class="stats stats-vertical lg:stats-horizontal shadow">
  <div class="stat text-center">
    <h1>Record</h1>
    <div class="stat-title text-primary">Pending</div>
    <div class="stat-value text-sm text-gray-200">{{ $betslips->whereNull('result')->count() }}</div>

    <div class="stat-title text-primary">Lost</div>
    <div class="stat-value text-sm text-danger">{{ $betslips->whereNotNull('result')->where('result', 0)->count() }}</div>

    <div class="stat-title text-primary">Won</div>
    <div class="stat-value text-sm text-success">{{ $betslips->whereNotNull('result')->where('result', 1)->count() }}</div>
  </div>
</div>


 <div class="stats stats-vertical lg:stats-horizontal shadow">
  <div class="stat text-center">
    <h1>Money</h1>
    <div class="stat-title text-primary">Pending</div>
    <div class="stat-value text-sm text-gray-200">${{ $betslips->whereNull('result')->sum('bet_amount') }}</div>

    <div class="stat-title text-primary">Lost</div>
    <div class="stat-value text-sm text-danger">${{ $betslips->whereNotNull('result')->where('result', 0)->sum('bet_amount') }}</div>

    <div class="stat-title text-primary">Won</div>
    <div class="stat-value text-sm text-success">
        --algo--
    </div>
  </div>
</div>
</div>

<div class="overflow-x-auto">
  <table class="table max-w-full">
            <!-- head -->
            <h1 class="py-2 underline underline-offset-y-4 text-sm italic text-gray-800">My Betslips</h1>
        
        <ul class="right flex justify-between">
            <li>
                <a href="{{ route('betslip.create') }}" class="btn btn-primary btn-sm" disabled>Export</a>
            </li>
            <li>
                <a href="{{ route('betslip.create') }}" class="btn btn-success btn-sm my-2">Add</a>
            </li>
        </ul>
            <thead>
            <tr>
                <th>Actions</th>
                <th>Sport</th>
                <th>Game</th>
                <th>Selection</th>
                <th>Odds</th>
                <th>Wager Amt</th>
                <th>Starts</th>
                {{--<th>Result</th>--}}
                <th>Note</th>

            </tr>
            </thead>
            <tbody>
            <!-- row 1 -->
            @forelse($betslips as $slip)
            <tr class="hover">
                <td class="flex justify-between flex-col">
                    <a href="{{ route('betslip.edit', ['betslip' => $slip->id]) }}" class="btn btn-success btn-sm my-2">Edit</a>

                    <a href="{{ route('betslip.delete', ['betslip' => $slip->id]) }}" class="btn btn-error btn-sm my-2">Delete</a>
                </td>
                <td class="text-sm text-left">
                    {{$slip->sport}}
                </td>

                <td class="text-sm text-left">
                    {{ $slip->event }}
                </td>
                <td class="flex flex-col">
                    <div class="font-semibold">
                    {{ $slip->selection }}
                    </div>

                    @if($slip->type)
                    <div class="text-primary text-xs">
                    {{ $slip->type?->value }}
                    </div>
                    @endif

                    @isset($slip->result)
                    <div @class([
                            'text-xs',
                            'text-success' => $slip->result,
                            'text-warning' => ! $slip->result,
                        ])>
                       

                    @if($slip->result)
                    <ul class='flex justify-around text-center text-sm pt-1'>
                        <li>WON</li>
                        <li>+ ${{$slip->profit['profit']}}</li>
                        {{--
                        <li><p class="text-xs text-gray-200 italic">Payout: </p>+{{ $slip->profit['total'] }}</li>
                        <li><p class="text-xs text-gray-200 italic">Profit: </p>+{{ $slip->profit['profit'] }}</li>
                        --}}
                    </ul>
                    @else
                    <ul class='flex justify-around text-center text-sm pt-1'>
                        <li>LOST</li>
                        <li>- {{ $slip->bet_amount }}</li>
                    </ul>
                    @endif
                    </div>
                 
                    
                    @else
                    <div>
                        <ul class='flex justify-around text-center text-sm pt-1'>
                        <li>PENDING</li>
                        <li>${{ $slip->bet_amount }}</li>
                    </ul>
                    </div>
                    @endif        
                </td>

                <td>
                {{ $slip->odds }}
                </td>

                <td>
                {{ $slip->bet_amount }}
                </td>

                <td>
                    {{ $slip->starts_at->diffForHumans() }}
                </td>
{{--
                @isset($slip->result)
                <td @class([ 'text-green-500' => $slip->result, 'text-red-500' => !$slip->result ])>
                    {{$slip->result ? 'Won' : 'Lost'}} | <p class="text-xs">{{$slip->pick?->name ?? $slip->option }}</p>
                </td>
                @else
                <td>
                    Pending
                </td>
                @endisset
--}}
                <td class="text-warning text-sm">
                    {{$slip->notes}}
                </td>

               
            </tr>
            @empty
            @endforelse
            </tbody>
            <!-- foot -->
            <tfoot>
            <tr>
                <th>Starts</th>
                <th>Sport</th>
                <th>Game</th>
                <th>Selection</th>
                <th>Odds</th>
                <th>Wager Amt</th>
                <th>Result</th>
                <th>Notes</th>

            </tr>
            </tfoot>

        </table>

        {{ $betslips->links() }}
  </div>
</div>

</x-app-layout>