<x-app-layout>

    <x-slot:title>Create Pool </x-slot:title>




    <div class="flex justify-center py-12">


        <div class="max-w-7xl">
            <h1 class="text-white underline text-xl underline-offset-y-4">Create Pick'em or Survivor Pool for the 2024-2025 NFL Season </h1>
            <h3 class="text-yellow-500 text-sm italic m-2">If you set an entry fee, you will have 10 days to make a payment. If no payment is made the pool will be deleted.</h3>


            <form action="{{ route('pool.post') }}" method="POST" class="max-w-4xl mx-auto p-6 rounded-lg shadow-md">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">Pool Name</label>
                        <input type="text" value="{{ old('name') }}" name="name" class="mt-1 block input input-bordered input-primary w-full sm:text-sm">
                    </div>

                    <div>
                        <label for="accessibility" class="block text-sm font-medium text-gray-700">Pool Accessibility</label>
                        <select name="public" class="select select-primary w-full max-w-xs">
                            <option value="true" selected>Public</option>
                            <option value="false">Unlisted / Private</option>
                        </select>
                    </div>

                    <div>
                        <label for="accessibility" class="block text-sm font-medium text-gray-700">Pool Type</label>
                        <select name="type" class="select select-primary w-full">
                            @foreach($types as $type)
                                @if($loop->first)
                            <option value="{{$type}}" selected>{{  ucfirst($type) }}</option>
                                @else
                            <option value="{{$type}}">{{  ucfirst($type) }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="entry_cost" class="block text-sm font-medium text-gray-700">Pool Entry Fee</label>
                        <input type="number" value="{{ old('entry_cost') ?? 0 }}" name="entry_cost" class="mt-1 block input input-bordered input-primary w-full sm:text-sm">
                    </div>
                    <div>
                        <label for="prize_type" class="block text-sm font-medium text-gray-700">Prize Type</label>
                        <select name="prize_type" class="select select-primary w-full">
                            @foreach($prizetypes as $ptype)
                                @if($loop->first)
                                    <option value="{{$ptype}}" selected>{{  ucfirst($ptype) }}</option>
                                @else
                                <option value="{{$ptype}}">{{  ucfirst($ptype) }}</option>
                                @endif
                                @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="prize" class="block text-sm font-medium text-gray-700">Prize (USD)</label>
                        <input type="number" value="{{ old('prize') ?? 0 }}" name="prize" placeholder="Prize Units" class="input input-bordered input-primary w-full" />
                    </div>
                    <div>
                        <label for="lives" class="block text-sm font-medium text-gray-700">Starting Lives Max(3)</label>
                        <input type="number"  name="lives_per_person" value="{{ old('lives_per_person') ?? 1 }}"placeholder="Starting / Max Lives" class="input input-bordered input-primary w-full" />
                    </div>
                    <div class="md:col-span-2">
                        <button type="submit" class="btn btn-primary btn-block">
                            Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>




    </x-app-layout>