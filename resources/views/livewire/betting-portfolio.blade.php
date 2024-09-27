 <x-slot:header>
    
      <ul class="right">
        <li>
             <a href="{{ route('betslip.index') }}" class="btn btn-primary btn-sm my-2">My Slips</a>
        </li>
      </ul>

 </x-slot:header>


<div class="flex flex-col max-w-7xl mx-auto px-2" x-data="{tz: Intl.DateTimeFormat().resolvedOptions().timeZone.toLocaleString()}">
    <div x-intersect="$wire.setTimezone(tz)"></div>

    
    
    <div class="flex justify-center mt-6">



        <x-mary-form wire:submit="save">
        <div class="grid grid-cols-2 gap-4 mt-6">
            @if(isset($potentialProfit))
            <div class="col col-span-2 text-center items-center">
                <h1 class="block text-primary text-xl">Potential Payout: {{ $potentialProfit['total'] }}</h1>
                <h1 class="block text-success text-lg">Potential Profit: +{{ $potentialProfit['profit'] }}</h1>
                <h1 class="block text-accent text-md">Implied Probability: {{ $potentialProfit['probability'] }}%</h1>
            </div>
            @endif

            <div class="col-span-2 text-sm">
               <h2 class="text-right underline text-gray-800 dark:text-gray-200 tracking-wide">
                    {{ __('Add Bet') }}
              </h2>
            </div>
            <div class="col col-span-2 text-center items-center">
                @error('selectedGameID')
                <h1 class="block text-primary text-xl text-center">{{ $message }}</h1>
                @enderror
            </div>
            <div>
                <label for="Sport" class="pt-0 label label-text font-semibold">Bet</label>
                <select wire:model.change="selectedSport" class="select select-primary w-full max-w-md">
                    @forelse($sports as $sport)
                    <option value="{{ $sport }}">{{ $sport }}</option>
                    @empty
                    @endforelse
                </select>
                @error('selectedSport')
                <label for="SportErrors" class="p-1 label label-text text-xs text-red-500">{{ $message }}</label>
                @enderror
            </div>
            @if($selectedSport === 'NFL')
            <div>
                <label for="Week" class="pt-0 label label-text font-semibold">Week</label>
                <select wire:model.change="selectedWeek" class="select select-primary w-full max-w-md">
                    @forelse(range(1,19) as $week)
                    <option value="{{ $week }}">{{ $week }}</option>
                    @empty
                    @endforelse
                </select>
                @error('selectedWeek')
                <label for="GameErrors" class="p-1 label label-text text-xs text-red-500">{{ $message }}</label>
                @enderror
            </div>
            <div>
                <label for="Game" class="pt-0 label label-text font-semibold">Game</label>
                <select wire:model.live="selectedGameID" class="select select-primary w-full text-sm" required>
                    <option>Select Game</option>
                    @forelse($nflGames as $game)
                    <option value="{{ $game->id }}">{{ $game->question }}</option>
                    @empty
                    @endforelse
                </select>
                @error('selectedGameID')
                <label for="GameErrors" class="p-1 label label-text text-xs text-red-500">{{ $message }}</label>
                @enderror
            </div>
            
            @if(isset($selectedGame))
            <div>
                <label for="Outcome" class="pt-0 label label-text font-semibold">Set Outcome</label>
                <select wire:model.live="selectedOutcomeID" class="select select-primary w-full max-w-md" required>
                    <option>Select Team</option>
                    @forelse($selectedGame->gameoptions as $outcomeOption)
                    <option value="{{ $outcomeOption?->team->id }}">{{ $outcomeOption?->option }}</option>
                    @empty
                    @endforelse
                </select>
                @error('selectedOutcomeID')
                <label for="GameErrors" class="p-1 label label-text text-xs text-red-500">{{ $message }}</label>
                @enderror
            </div>
            
            <div>
                <x-mary-datetime label="Date + Time" wire:model.live="eventStart" icon="o-calendar" type="datetime-local" disabled />
                @error('eventStart')
                <label for="SportErrors" class="p-1 label label-text text-xs text-red-500">{{ $message }}</label>
                @enderror
            </div>
            <div>
                <label for="Timezone" class="pt-0 label label-text font-semibold">Set Timezone</label>
                <select wire:model.change="TZ" class="select select-primary w-full max-w-md" required>
                    @forelse($timezones as $timezone)
                    <option value="{{ $timezone }}">{{ $timezone }}</option>
                    @empty
                    @endforelse
                </select>
            </div>


            <x-mary-input label="American Odds" type="number" step="20" wire:model="odds" required />
            <x-mary-input label="Amount" wire:model="betAmount" prefix="USD" type="number" step="5" required />

            @if(now() > $eventStart)
            <div>
                <label for="status" class="pt-0 label label-text font-semibold">Game Status</label>
                <div class="form-control">
                    <label class="label cursor-pointer">
                        <span class="label-text">Auto</span>
                        <input type="radio" name="radio-10" class="radio checked:bg-gray-500" checked="checked" />
                    </label>
                </div>
                <div class="form-control">
                    <label class="label cursor-pointer">
                        <span class="label-text">Won</span>
                        <input type="radio" value="1" name="radio-10" wire:model.change="hasResult" class="radio checked:bg-success-500" />
                    </label>
                </div>
                <div class="form-control">
                    <label class="label cursor-pointer">
                        <span class="label-text">Lost</span>
                        <input type="radio" value="0" name="radio-10" wire:model.change="hasResult" class="radio checked:bg-red-500" />
                    </label>
                </div>
            </div>
            @endif 

            @endif

            @else
            <x-mary-input label="Event" wire:model="eventName" />
            
            <x-mary-datetime label="Date + Time" wire:model.live="eventStart" icon="o-calendar" type="datetime-local" />
            <div>
                <label for="Timezone" class="pt-0 label label-text font-semibold">Set Timezone</label>
                <select wire:model.change="TZ" class="select select-primary w-full max-w-md" required>
                    @forelse($timezones as $timezone)
                    <option value="{{ $timezone }}">{{ $timezone }}</option>
                    @empty
                    @endforelse
                </select>
            </div>
            {{--<x-mary-input label="Bet Outcome" wire:model="eventOption" required />--}}

            <div class="col-span-2">
            <x-mary-choices-offline label="Bet Outcome" wire:model="selectedOutcomeID" :options="$betOptions" single searchable />
        </div>
            <x-mary-input label="American Odds" type="number" step="20" wire:model="odds" required />
            <x-mary-input label="Amount" wire:model="betAmount" prefix="USD" type="number" step="5" required />
            
            @if(now() > $eventStart)
            <div>
                <label for="status" class="pt-0 label label-text font-semibold">Game Status</label>
                <div class="form-control">
                    <label class="label cursor-pointer">
                        <span class="label-text">Auto</span>
                        <input type="radio" name="radio-10" class="radio checked:bg-gray-500" checked="checked" />
                    </label>
                </div>
                <div class="form-control">
                    <label class="label cursor-pointer">
                        <span class="label-text">Won</span>
                        <input type="radio" value="1" name="radio-10" wire:model.change="hasResult" class="radio checked:bg-success-500" />
                    </label>
                </div>
                <div class="form-control">
                    <label class="label cursor-pointer">
                        <span class="label-text">Lost</span>
                        <input type="radio" value="0" name="radio-10" wire:model.change="hasResult" class="radio checked:bg-red-500" />
                    </label>
                </div>
            </div>
            @endif
            @endif

            <x-mary-choices-offline label="Bet Type" wire:model="selectedBetType" :options="$betTypes" single searchable />
        
            <x-mary-textarea label="Notes" hint="optional" wire:model="notes" />
            

            
            
            <x-slot:actions>
            
            <x-mary-button label="Add" class="btn-success" icon="o-plus" type="submit" spinner="save" />
            <x-mary-button label="Parlay" class="btn-primary" icon="o-plus" disabled />
            <x-mary-button label="Parlay" class="btn-primary" icon="o-plus" disabled />
            </x-slot:actions>
        </div>
        </x-mary-form>
    </div>
</div>