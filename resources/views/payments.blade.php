<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('My Payments') }}
        </h2>
    </x-slot>

    <div class="py-2">
        @session('success')
        <div class="flex justify-center">
            <div class="p-4 bg-green-500 rounded-xl max-w-7xl text-white text-xl text-center">
                {{ $value }}
            </div>
        </div>
        @endsession

        @session('error')
        <div class="flex justify-center">
            <div class="p-4 bg-red-500 rounded-xl max-w-7xl text-white text-xl text-center">
                {{ $value }}
            </div>
        </div>
        @endsession

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex flex-col justify-center mt-2">
                <div class="overflow-x-auto">
                    <table class="table">
                        <!-- head -->
                        <thead>
                        <tr class="text-center">

                            <th>ID#</th>
                            <th>Pool</th>
                            <th>Amount USD</th>
                            <th>Amount Crypto</th>
                            <th>Payment Method</th>
                            <th>Created</th>

                        </tr>
                        </thead>
                        <tbody>
                        @forelse($payments as $payment)
                            <tr class="hover text-center">
                                <td>{{ $payment->payment_id }}</td>
                                <td>{{ $payment->pool->name }}</td>
                                <td>{{ $payment->amount_usd }}</td>
                                <td>{{ $payment->amount_crypto }}</td>
                                <td>{{ $payment->crypto_method }}</td>
                                <td>{{ $payment->created_at->diffForHumans() }}</td>
                            </tr>
                        @empty
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>