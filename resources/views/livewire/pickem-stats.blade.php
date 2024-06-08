<div x-data="{ pickemstable: true, leaderboard: true }" x-init="leaderboard = false,pickemstable = true">
    <div class="flex justify-center mx-auto">
        <div class="flex-flex-col space-y-2">
            <div>
                <a class="btn btn-sm" @click="leaderboard = ! leaderboard" x-text="leaderboard ? 'Hide Leaderboard' : 'Show Leaderboard'" :class="leaderboard ? 'btn-error' : 'btn-primary'">

                </a>
            </div>
            <div>
                <a class="btn btn-sm" @click="pickemstable = ! pickemstable" x-text="pickemstable ? 'Hide Pickem Log' : 'Show Pickem Log'" :class="pickemstable ? 'btn-error' : 'btn-primary'">

                </a>
            </div>
        </div>
    </div>
    <div x-show="leaderboard" x-collapse>
        <h1 class="text-xl tracking-wide text-accent text-center my-2">{{$pool->name}} Pick'em Leaderboard</h1>
        <table class="table">
            <!-- head -->
            <thead>
            <tr>
                <th>Rank</th>
                <th>User</th>
                <th>Record</th>
            </tr>
            </thead>
            <tbody>
            <!-- row 1 -->
            @forelse($leaderboard as $contender)
                <tr>
                    <td>
                        {{$contender->rank}}
                    </td>
                    <td>
                        {{$contender->user->name}}
                    </td>
                    <td class="flex justify-evenly">
                        <p class="text-green-500 px-2">{{ $contender->record["Won"] ?? 0 }}</p> - <p class="text-red-500 px-2"> {{ $contender->record["Lost"]  ?? 0}}</p>
                    </td>
                </tr>
            @empty
            @endforelse
            </tbody>
            <!-- foot -->
            <tfoot>
            <tr>
                <th>Rank</th>
                <th>User</th>
                <th>Record</th>

            </tr>
            </tfoot>

        </table>
    </div>
    <div x-show="pickemstable" x-collapse>
        <h1 class="text-xl tracking-wide text-primary text-center my-2">My Pickem Log</h1>
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
                <td @class(['text-green-500' => $pickem->selection_id === $pickem->results?->winner, 'text-red-500' => $pickem->selection_id !== $pickem->results?->winner ])>
                    {{$pickem->selection}}
                </td>
                <td>
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
