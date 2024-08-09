<x-filament::page>
    <ul class="flex justify-between text-primary-400">
        <li>{{ $record->question->question}}</li>
        <li>{{ 'Week: '.$record->week }}</li>
        <li>{{ 'User: '.$record->user->name }}</li>
        <li>{{ 'Pool: '.$record->pool->pool->name }}</li>
        <li>Ended: {{ $record->question->ended ? 'Yes' : 'No'}}</li>
    </ul>

        <x-filament-panels::form wire:submit="save">
        {{ $this->form }}
 
        <x-filament-panels::form.actions
            :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()"
        />
    </x-filament-panels::form>

</x-filament::page>