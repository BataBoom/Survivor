<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
           Trophy Room | Survivor Legends
        </h2>
    </x-slot>



    <div class="flex flex-col md:space-y-4 lg:space-y-0 lg:grid lg:grid-cols-2 lg:gap-4 justify-center mx-4">

        <div id="container" class="col h-full max-w-lg">
            <h1 class="block pb-2 tracking-wider underline decoration-slate-100 decoration-wavy underline-offset-4">2023-2024 Season</h1>
            <div class="glass rounded-lg bg-gradient-to-tr from-amber-500 via-yellow-300 to-amber-300 p-4 px-4 py-4">
                <div class="glass flex h-full w-full items-center justify-center rounded-xl bg-gradient-to-br from-stone-200/50 via-slate-100/60 to-stone-200/20 p-4 text-center">
                    <div>
                        <div id="avatar" class="flex justify-center pt-4">
                            <div class="h-32 rounded-3xl border-2 border-slate-500/90">
                                <img class="h-full w-full rounded-3xl" src="https://i.imgur.com/e1yjxWj.png" alt="Roon3y" />
                            </div>
                        </div>
                        <div id="name-plate" class="m-2 rounded-3xl bg-amber-500/50">
                            <div class="flex justify-center text-center">
                                <div>
                                    <div class="flex items-center justify-center text-center">
                                        <div class="flex flex-col items-center text-center">
                                            <div>
                                                <p class="inline-block bg-gradient-to-r from-amber-500 via-yellow-500 to-amber-500 bg-clip-text p-1 text-3xl font-semibold tracking-wide text-transparent">BB</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <ul id="accomplishments" class="divide-y-2 divide-dotted divide-amber-500/70 text-base font-semibold">
                            <li class="flex justify-between py-1 text-yellow-500">
                                <span class="mx-6">Earnings</span>
                                <span class="mx-6">0.01 BTC</span>
                            </li>
                            <li class="flex justify-between items-center  py-1 text-yellow-500">
                                <span class="mx-6">Record</span>
                                <span class="mx-6">13-0</span>
                            </li>
                            <li class="flex justify-between items-center py-1 text-indigo-400">
                                <span class="mx-6">Pool</span>
                                <span class="mx-6">Alpha</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>

</x-app-layout>
