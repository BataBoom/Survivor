<x-filament::page>
    <ul class="text-gray-200">
        <li>{{ $record->question->question}}</li>
        <li>{{ 'Week: '.$record->week }}</li>
        <li>{{ 'User: '.$record->user->name }}</li>
        <li>{{ 'Pool: '.$record->pool->pool->name }}</li>
        <li>Ended: {{ $record->question->ended ? 'Yes' : 'No'}}</li>
        <li @class([
        'text-green-500' => $record->pool->alive,
        'text-red-500' => !$record->pool->alive,
        ])>Contender Alive: {{ $record->pool->alive ? 'Yes' : 'No'}}</li>
    </ul>

        <x-filament-panels::form wire:submit="save">
        {{ $this->form }}
 
        <x-filament-panels::form.actions
            :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()"
        />
    </x-filament-panels::form>

</x-filament::page>