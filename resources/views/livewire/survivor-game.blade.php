<div>
    <div class="card flex-card survivor-card raised">
        <div class="card-heading is-bordered has-text-center">
            <h4 class="is-size-5">NFL Survivor - Week {{ $week }} | @if ($status)
                    <span style="color:#75ff33">Alive</span>
                @else
                    <span class="has-text-danger">Dead</span>
                @endif
            </h4>
        </div>
        <div class="card-body">
            <div class="columns">
                <div class="column is-two-thirds">
                    <div class="yourmenu">

                        @if (session()->has('errormsg'))
                            <article class="message msg-danger" id="errormsg">
                                <h4 class="message-header">
                                    <span>Error</span>
                                    <span class="delete" aria-label="delete" onclick="document.getElementById('errormsg').style.display='none';"></span>
                                </h4>
                                <div class="message-body">
                                    {{ session('errormsg') }}
                                </div>
                            </article>
                        @endif

                        @if (session()->has('successmsg'))
                            <article class="message msg-success" id="successmsg">
                                <h4 class="message-header">
                                    <span>Success</span>
                                    <span class="delete" aria-label="delete" onclick="document.getElementById('successmsg').style.display='none';"></span>
                                </h4>
                                <div class="message-body">
                                    {{ session('successmsg') }}
                                </div>
                            </article>
                        @endif

                        @if ($latestpick)
                            <div class="lastselection">

                                <h1 class="has-text-warning is-size-4 is-left"><u>Your Last Selection</u>: </h1>
                                @forelse ($latestpick as $pickwk => $last)
                                    <p class="has-text-secondary">Week {{ $pickwk }}: {{ $last }}</p>
                                    @endforeach


                                    <div class="block"></div>
                                    <ul class="ledger" wire:ignore>
                                        <li>
                                            <span class="ledger-dot" style="background-color: #fff;"></span>
                                            <span class="ledger-text">Pending</span>
                                        </li>
                                        <li>
                                            <span class="ledger-dot" style="background-color: #1dd985;"></span>
                                            <span class="ledger-text">Won</span>
                                        </li>
                                        <li>
                                            <span class="ledger-dot" style="background-color: #ff0000;"></span>
                                            <span class="ledger-text">Lost</span>
                                        </li>
                                        @if ($delPicks->isNotEmpty() && request()->routeIs('survivor'))
                                            <li>

                                                <a class="button is-phantom primary-button is-fullwidth"
                                                   style="font-size: .75rem;" href="#popup">Remove Selection?</a>

                                            </li>
                                        @endif
                                    </ul>
                                    <h1 class="has-text-warning is-size-4 is-left"><u>Your Selections</u>:</h1>
                                    <ul>

                                        @forelse ($mypicks as $pick)
                                            @if ($pick->result !== null)
                                                <li class="has-text-{{ $pick->result ? 'success' : 'danger' }}">Week {{ $pick->week }}: {{ $pick->selection }}


                                                </li>
                                            @else
                                                <li class="has-text-secondary">Week {{ $pick->week }}: {{ $pick->selection }}


                                                </li>
                                            @endif

                                        @empty
                                        @endforelse
                                    </ul>

                            </div>
                            <div class="block"></div>
                        @else
                            <div class="column" class="py-4 px-4"
                                 style="border: 10px dotted #7393B3; border-radius: 200px 200px 200px 200px;
-webkit-border-radius: 200px 200px 200px 200px;
-moz-border-radius: 200px 200px 200px 200px;">
                                <h1 class="has-text-white has-text-centered p-6" style="letting-spacing:2px;">Welcome to
                                    NBZ NFL Survivor, {{ Auth::user()->name }}! Select a team to begin</h1>
                            </div>
                        @endif
                        @if ($week != 1)
                            <h1 style="font-family: 'Proza Libre', sans-serif;"
                                class="has-text-danger is-size-3 underline bold is-left"><u>Week {{ $week - 1 }}'s
                                    Biggest Loser</u>:</h1>
                            <div class="padding-30 has-text-centered"
                                 style="background-color: #2f3b50;border-radius:30px;">

                                @if ($biggestLoser)
                                    @foreach ($biggestLoser as $l => $v)
                                        <p style="font-family: 'Proza Libre', sans-serif; letter-spacing: 5px;"
                                           class="has-text-white">Lives Taken: <span
                                                    class="has-text-warning">{{ $l }}x</span> |
                                            {{ $v }}</p>
                                    @endforeach
                                @else
                                    <p style="font-family: 'Proza Libre', sans-serif; letter-spacing: 5px;"
                                       class="has-text-white">No Losers</p>
                                @endif
                            </div>
                        @else
                        @endif
                        <div class="block"></div>
                        <h1 style="font-family: 'Proza Libre', sans-serif;"
                            class="has-text-warning is-size-4 underline bold is-left"><u>Player Count</u>:</h1>
                        <div class="has-text-centered py-2 px-2" style="background-color: #2f3b50;border-radius:30px;">

                            <p style="font-family: 'Proza Libre', sans-serif; letter-spacing: 5px;"
                               class="has-text-white"><span style="color:#7FFFD4;">{{ $playerCount['Alive'] }}</span> Alive | <span
                                        style="color:#EE4B2B;">{{ $playerCount['Dead'] }}</span> Dead</p>
                        </div>
                    </div>
                    <div class="block"></div>
                    <div class="control has-validation">
                        <div class="control">
                            <div class="select is-fullwidth is-large has-text-center">
                                <select class="has-text-centered" wire:model.lazy="newweek">
                                    <label>Change Week</label>
                                    @php
                                        $w = range(0, 18);
                                    @endphp
                                    @foreach ($w as $k)
                                        @if ($k == 0)
                                            <option value="{{ $whatweek }}" selected>Week {{ $whatweek }}
                                            </option>
                                        @elseif($k == $whatweek)
                                        @else
                                            <option class="is-size-4" value="{{ $k }}">Week
                                                {{ $k }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="block"></div>
                    <button class="button is-solid accent-button is-fullwidth" wire:click="changeWeek"
                            wire:loading.attr="disabled">Change Week</button>

                </div>
                <div class="column is-one-quarter is-right has-text-center">
                    <h1 class="has-text-white is-size-4">Week {{ $week }} </h1>
                    <div class="block"></div>

                    <form wire:submit.prevent="submit">
                        <div class="control pb-4">
                            <div class="select is-multiple is-fullwidth">
                                <select multiple size="10" class="select is-large has-text-center team-select"
                                        wire:model.defer="pickteam">
                                    <label>Select Team</label>
                                    @foreach ($choices as $choice)
                                        <option class="is-size-5"> {{ $choice->get('name') }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <button class="button is-solid accent-button is-fullwidth" wire:click="submit" type="submit"
                                wire:loading.attr="disabled">Submit Pick</button>

                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="block"></div>
    <div class="columns is-multiline">
        @foreach ($allGames[1] as $index => $g)
            <div class="column is-6">
                <center>
                    <div class="updated chip">
                        <div class="card-title">

                            <span>{{ $g['game'] }}</span>
                        </div>

                        <h6> {{ date('l F jS', strtotime($g['starts'])) }}</h6>


                        <img src="/images/logo/nfl/{{ trim(str_replace(' ', '', $g['info'][0]['name'])) }}.png">

                        <img src="/images/logo/nfl/{{ trim(str_replace(' ', '', $g['info'][1]['name'])) }}.png">


                        <div class="block"></div>
                        <div class="depth">
                            <ul class="list-left">
                                <li>
                                    <a class="button is-rounded is-reversed-phantom accent-button"
                                       href="https://www.espn.com/nfl/team/depth/_/name/{{ $g['info'][0]['abbreviation'] }}"
                                       target="new_window">{{ $g['info'][0]['abbreviation'] }} Depth Chart</a>
                                </li>
                                <li>
                                    <a class="button is-rounded is-phantom accent-button"
                                       href="https://www.espn.com/nfl/team/injuries/_/name/{{ $g['info'][0]['abbreviation'] }}"
                                       target="new_window">{{ $g['info'][0]['abbreviation'] }} Injuries</a>
                                </li>
                            </ul>
                            <ul class="list-right">
                                <li>
                                    <a class="button is-rounded is-reversed-phantom accent-button"
                                       href="https://www.espn.com/nfl/team/depth/_/name/{{ $g['info'][1]['abbreviation'] }}"
                                       target="new_window">{{ $g['info'][1]['abbreviation'] }} Depth</a>
                                </li>
                                <li>
                                    <a class="button is-rounded is-phantom accent-button"
                                       href="https://www.espn.com/nfl/team/injuries/_/name/{{ $g['info'][1]['abbreviation'] }}"
                                       target="new_window">{{ $g['info'][1]['abbreviation'] }} Injuries</a>
                                </li>
                            </ul>
                        </div>
                        <div class="block"></div>
                        <a class="button is-rounded is-solid accent-button"
                           href="https://www.espn.com/nfl/game/_/gameId/{{ $g['gid'] }}"
                           target="new_window">Game Preview</a>
                    </div>
                </center>

            </div>
        @endforeach

    </div>
    <!-- Modal Markup -->
    <div id="horizontal-form-modal" class="modal modal-lg modal-warning">
        <div class="modal-background"></div>
        <div class="modal-content">
            <div class="flex-card simple-shadow">
                <div class="card-body">
                    <h2 class="title is-4 text-bold mb-40">Remove Pick</h2>
                    <form wire:submit.prevent="RemovePick">
                        <div class="select is-multiple is-fullwidth">
                            <select multiple size="{{ $delPicks->count() }}"
                                    class="select is-large has-text-center team-select" wire:model.defer="delteam">
                                <label>Select Team</label>
                                @foreach ($delPicks as $dp)
                                    <option class="is-size-5" value="{{ $dp->selection }}"> Week
                                        {{ $dp->week . ' - ' . $dp->selection }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-10">
                            <button class="button button-cta warning-btn is-fullwidth modal-dismiss"
                                    style="background-color: #eda514;color:#fff;" wire:click="RemovePick" type="submit"
                                    wire:loading.attr="disabled">Remove Pick</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <button class="modal-close is-large is-hidden" aria-label="close"></button>
    </div>




    <div class="popup" id="popup">
        <div class="popup__content">
            <h2 class="heading-secondary">Remove Pick</h2>
            <div class="popup__text">
                <form wire:submit.prevent="RemovePick">
                    <div class="select is-multiple is-fullwidth">
                        <select multiple size="{{ $delPicks->count() }}"
                                class="select is-large has-text-center team-select" wire:model.defer="delteam">
                            <label>Select Team</label>
                            @foreach ($delPicks as $dp)
                                <option class="is-size-5" value="{{ $dp->selection }}"> Week
                                    {{ $dp->week . ' - ' . $dp->selection }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-10">
                        <button class="button button-cta warning-btn is-fullwidth modal-dismiss"
                                style="background-color: #eda514;color:#fff;border-color: #eda514;"
                                wire:click="RemovePick" type="submit" wire:loading.attr="disabled">Remove Pick</button>
                    </div>
                </form>
            </div>
            <a href="#" class="button"
               style="border-color: #dbdbdb;background-color: #fff;color: #363636;border-width: 1px;">Close Popup</a>
        </div>
    </div>
    <!-- /Modal Markup -->
    <script>
        function enableWager(obj) {
            var icon = obj.options[obj.selectedIndex].getAttribute('data-icon');
            alert(icon);
        }
    </script>
</div>
