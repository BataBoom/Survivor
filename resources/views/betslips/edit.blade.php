<x-app-layout>

 <x-slot:header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit bet') }}
      </h2>

      <ul class="right">
        <li>
             <a href="{{ route('betslip.create') }}" class="btn btn-success btn-sm my-2">New</a>
        </li>
        <li>
             <a href="{{ route('betslip.index') }}" class="btn btn-success btn-sm my-2">Overview</a>
        </li>
        <li>
             <a href="{{ route('betslip.delete', ['betslip' => $betslip->id]) }}" class="btn btn-error btn-sm my-2">Delete</a>
        </li>
      </ul>
 </x-slot:header>


<div class="max-w-7xl mx-auto space-y-2">

    



   <form action="{{ route('betslip.update', ['betslip' => $betslip->id]) }}" method="POST" class="max-w-4xl mx-auto p-6 rounded-lg shadow-md">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700">Selection</label>
                    <input type="text" value="{{ $betslip->selection }}" name="selection_id" class="mt-1 block input input-bordered input-primary w-full sm:text-sm" disabled>
                </div>

                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700">Odds</label>
                    <input type="number" value="{{ $betslip->odds }}" name="odds" class="mt-1 block input input-bordered input-primary w-full sm:text-sm">
                </div>

                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700">Bet Amount</label>
                    <input type="number" value="{{ $betslip->bet_amount }}" name="bet_amount" class="mt-1 block input input-bordered input-primary w-full sm:text-sm">
                </div>

          
            <div>
                <label for="status" class="pt-0 label label-text font-semibold">Game Status</label>
                <div class="form-control">
                    <label class="label cursor-pointer">
                        <span class="label-text">Auto</span>
                        <input type="radio" value="null" name="result" class="radio checked:bg-success" @checked(is_null($betslip->result)) />
                    </label>
                </div>
                <div class="form-control">
                    <label class="label cursor-pointer">
                        <span class="label-text">Won</span>
                        <input type="radio" value="1" name="result" class="radio checked:bg-green-500" @checked(isset($betslip->result) && $betslip->result == 1) />
                    </label>
                </div>
                <div class="form-control">
                    <label class="label cursor-pointer">
                        <span class="label-text">Lost</span>
                        <input type="radio" value="0" name="result" class="radio checked:bg-red-500" @checked(isset($betslip->result) && $betslip->result == 0) />
                    </label>
                </div>
            </div>
            

                <div class="md:col-span-2">
                    <button type="submit" class="btn btn-primary btn-block">
                        Submit
                    </button>
                </div>
            </div>
        </form>
</div>
</x-app-layout>