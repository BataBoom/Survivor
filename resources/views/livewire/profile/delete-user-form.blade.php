<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;

use function Livewire\Volt\rules;
use function Livewire\Volt\state;
use App\Models\DeleteUser;

state(['password' => '']);

rules(['password' => ['required', 'string', 'current_password']]);
if(now() > config('survivor.over_date')) {
$deleteUser = function (Logout $logout) {
    $this->validate();

    tap(Auth::user(), $logout(...))->delete();

    $this->redirect('/', navigate: true);
};
} else {
    $deleteUserV2 = function (Logout $logout) {
        $this->validate();

        DeleteUser::Create(['user_id' => Auth::user()->id]);

        Auth::logout();

        $this->redirect('/', navigate: true);
    };
}
$cancelDelete = function() {
    DeleteUser::Where(['user_id' => Auth::user()->id])->delete();
    $this->redirect('/profile', navigate: true);

}
?>



<section class="space-y-6">
    @if(now() > config('survivor.over_date'))
    <header>
        <h2 class="text-lg font-medium text-gray-100">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>


    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Delete Account') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="deleteUser" class="p-6">

            <h2 class="text-lg font-medium text-gray-100">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-400">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    wire:model="password"
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
    @else
        @if(!Auth::user()->hasDeletedSelf())
        <header>
            <h2 class="text-lg font-medium text-gray-100">
                {{ __('Delete Account') }}
            </h2>

            <p class="mt-1 text-sm text-gray-400">
                {{ __('Cannot Delete Account until the season has finished. Approximately ') }} {{ config('survivor.over_date')->diffForHumans() }}
            </p>
        </header>

        <x-danger-button
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletionv2')"
        >{{ __('Logout & Delete Account at earliest availability') }}</x-danger-button>

        <x-modal name="confirm-user-deletionv2" :show="$errors->isNotEmpty()" focusable>
            <form wire:submit="deleteUserV2" class="p-6">

                <h2 class="text-lg font-medium text-gray-100">
                    {{ __('Are you sure you want to delete your account?') }}
                </h2>

                <p class="mt-1 text-sm text-gray-400">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </p>

                <div class="mt-6">
                    <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                    <x-text-input
                            wire:model="password"
                            id="password"
                            name="password"
                            type="password"
                            class="mt-1 block w-3/4"
                            placeholder="{{ __('Password') }}"
                    />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-danger-button class="ms-3">
                        {{ __('Delete Account') }}
                    </x-danger-button>
                </div>
            </form>
        </x-modal>
        @else

            <h1>Your Account will be deleted after the season, approximately {{ config('survivor.over_date')->diffForHumans() }}</h1>
            <button wire:click="cancelDelete" class="btn btn-primary">Cancel Deletion?</button>
            @endif

    @endif
</section>

