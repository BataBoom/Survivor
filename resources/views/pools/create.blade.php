<x-app-layout>

    <x-slot:title>Create Pool </x-slot:title>

    <div class="flex justify-center py-12">


        <div class="max-w-7xl">
            @if ($errors->any())
                <div class="flex justify-center pb-4">
                    @foreach ($errors->all() as $error)
                        <div class="p-4 bg-red-500 rounded-xl max-w-7xl text-white text-xl text-center">
                            {{ $error }}
                        </div>
                    @endforeach
                </div>
            @endif

            @session('error')
            <div class="flex justify-center pb-4">
                <div class="p-4 bg-red-500 rounded-xl max-w-7xl text-white text-xl text-center">
                    {{ $message }}
                </div>
            </div>
            @endsession

            <h1 class="text-white underline text-xl underline-offset-y-4">Create Pick'em or Survivor Pool for the 2024-2025 NFL Season </h1>

            <ul class="list-disc list-inside leading-7 text-red-500">
                <li class="block py-2">If you set an entry fee, you will have 10 days to make a payment. The pool will be unlisted until payment is made. </li>
                <li class="block py-2">Leave Guaranteed Prize Field at zero/empty if you only want prize to include Entry Fee's.</li>
                <li class="block py-2">Prize Type is irrelevant and can be left alone if no entry fee or guaranteed prize is set.</li>

            </ul>

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
                            <option selected value="true">Public</option>
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
                            <option value="{{$type}}" disabled>{{  ucfirst($type) }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="entry_cost" class="block text-sm font-medium text-gray-700">Pool Entry Fee</label>
                        <input type="number" value="{{ old('entry_cost') ?? 0 }}" min="0" name="entry_cost" class="mt-1 block input input-bordered input-primary w-full sm:text-sm">
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
                        <label for="prize" class="block text-sm font-medium text-gray-700">Guaranteed Prize (USD)</label>

                        <input type="number" value="{{ old('guaranteed_prize') ?? 0 }}" min="0" name="guaranteed_prize" placeholder="Prize Units" class="input input-bordered input-primary w-full" />
                    </div>
                    <div>
                        <label for="lives" class="block text-sm font-medium text-gray-700">Starting Lives | Max (3)</label>
                        <input type="number" name="lives_per_person" min="1"  value="{{ old('lives_per_person') ?? 1 }}" placeholder="Starting / Max Lives" class="input input-bordered input-primary w-full" />
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