<div x-data="{ pickemstable: true, leaderboard: true, stats: true }" x-init="leaderboard = true,pickemstable = true, stats = true">
    <div class="flex justify-center mx-auto">
        <div class="flex-flex-col space-y-2">
            <div  class="flex justify-center">
                @if($whatweek > 0)
                <a class="btn btn-sm" @click="leaderboard = ! leaderboard" x-text="leaderboard ? 'Hide Leaderboard' : 'Show Leaderboard'" :class="leaderboard ? 'btn-error' : 'btn-primary'">
                @endif
                </a>
            </div>
            <div  class="flex justify-center">
                <a class="btn btn-sm" @click="pickemstable = ! pickemstable" x-text="pickemstable ? 'Hide Pickem Log' : 'Show Pickem Log'" :class="pickemstable ? 'btn-error' : 'btn-primary'">

                </a>
            </div>
            <div class="flex justify-center">
                <a class="btn btn-sm" @click="stats = ! stats" x-text="stats ? 'Hide Stats' : 'Show Stats'" :class="stats ? 'btn-error' : 'btn-primary'">

                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:gap-4">
        
<div x-show="stats" class='flex justify-center mt-10'>
 <div class="stats stats-vertical lg:stats-horizontal shadow">
  <div class="stat text-center">
    <div class="stat-title text-primary">Most Picked</div>
    <div class="stat-value text-sm text-secondary">{{ $myFavTeams->first()->team->name }}</div>
    <div class="stat-desc italic">My Top Picked ({{ $myFavTeams->first()->wins }} - {{$myFavTeams->first()->losses}})</div>
    <div class="stat-value text-sm text-accent">{{ $poolFavTeams->first()->team->name }}</div>
    <div class="stat-desc italic">Pool Top Picked ({{ $poolFavTeams->first()->wins }} - {{$poolFavTeams->first()->losses}})</div>
  </div>
{{--
  <div class="stat text-center">
    <div class="stat-title text-primary">My Conference Record</div>
    <div class="stat-value">{{ $mycard->conferenceRecord["AFC"] }}  <p class="text-sm italic text-secondary">AFC</p></div>
   
    <div class="stat-value">{{ $mycard->conferenceRecord["NFC"] }}  <p class="text-sm italic text-accent">NFC</p></div>
   
  </div>
--}}

  <div class="stat text-center">
    <div class="stat-title text-primary">Divisional Picks</div>
    <ul class="stat-value text-sm">
        @forelse($mycard->TopPickedDivisons as $k => $tm)
        <li>{{ $k }} - ({{$tm}}x)</li>
        @empty
        @endforelse
      </ul>
    <div class="stat-desc italic p-1">- My Favorites</div>
  </div>

 
    <div class="stat text-center">
    <div class="stat-title text-primary">My Conference Picks</div>
    <ul class="stat-value">
        <li>{{ $mycard->NFC_Record["Won"] }} - {{ $mycard->NFC_Record["Lost"] }}
        <p class="text-sm italic text-accent">NFC</p>
        </li>
        <li>{{ $mycard->AFC_Record["Won"] }} - {{ $mycard->AFC_Record["Lost"] }}
        <p class="text-sm italic text-secondary">AFC</p>
        </li>
      </ul>
      <div class="stat-desc italic p-1"></div>
  </div>
  
</div>
</div>


    @if($whatweek > 0)
    <div x-show="leaderboard" x-collapse>
        <h1 class="text-xl tracking-wide text-accent text-center my-2 pt-6">{{$pool->name}} Leaderboard</h1>
        <table class="table">
            <!-- head -->
            <thead>
            <tr class="text-center">
                <th>Rank</th>
                <th>User</th>
                <th>Record</th>
            </tr>
            </thead>
            <tbody class="text-center">
            <!-- row 1 -->
            @forelse($leaderboard as $contender)
                <tr @class(['hover', 'border-dashed border border-primary' => $loop->last, 'border-dashed border border-success' => $contender->user === Auth::user()->name])>
                    <td>
                        {{$contender->rank}}
                    </td>
                    <td class="text-lg">
                        {{$contender->user}}
                    </td>
                    <td class="flex justify-evenly text-lg">
                        <p class="text-green-500 px-2">{{ $contender->record["Won"] ?? 0 }}</p> - <p class="text-red-500 px-2"> {{ $contender->record["Lost"]  ?? 0}}</p>
                    </td>
                </tr>
            @empty
            @endforelse
            </tbody>

        </table>
    </div>
    @endif
    <div x-show="pickemstable" x-collapse>
        <h1 class="text-xl tracking-wide text-primary text-center my-2 pt-6">My Pickem Log</h1>
        <table class="table">
            <!-- head -->
            <thead>
            <tr>
                <th>Week</th>
                <th>Game</th>
                <th>Pick</th>
                <th>Result</th>
            </tr>
            </thead>
            <tbody>
            <!-- row 1 -->
            @forelse($pickems as $pickem)
            <tr>
                <td>
                    {{$pickem->week}}
                </td>
                <td>
                    {{$pickem->question->question}}
                </td>
                @if($pickem->results)
                <td @class(['text-green-500' => $pickem->result, 'text-red-500' => !$pickem->result ])>
                    {{$pickem->selection}}
                </td>
                <td  @class(['text-green-500' => $pickem->result, 'text-red-500' => !$pickem->result ])>
                        {{$pickem->result ? 'Won' : 'Lost'}}
                </td>
                @else
                <td>{{$pickem->selection}}</td>
                <td>Pending</td>
                @endif
            </tr>
            @empty
            @endforelse
            </tbody>
            <!-- foot -->
            <tfoot>
            <tr>
                <th>Week</th>
                <th>Game</th>
                <th>Pick</th>
                <th>Result</th>

            </tr>
            </tfoot>

        </table>

        {{ $pickems->links() }}
    </div>
</div>
</div>
