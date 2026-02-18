<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
           Trophy Room | Legends
        </h2>
    </x-slot>


    <h2 class="block py-2 tracking-wider font-semibold text-xl text-gray-200 leading-tight">
        Survivor Legends
    </h2>
    <div class="flex flex-col md:space-y-4 lg:space-y-0 lg:grid lg:grid-cols-3 lg:gap-4 justify-center mx-4">

        <div id="container" class="col h-full max-w-lg">
            <h1 class="block pb-2 tracking-wider underline decoration-slate-100 decoration-wavy underline-offset-4">2025-2026 Season</h1>
            <div class="flex flex-col">

            <x-trophy-card
                username="DrewShot19"
                pfp="https://ui-avatars.com/api/?rounded=false&name=DrewShot19&size=128&background=f1c232"
                twitter="#"
                record="13-1"
                earnings="0.0017 BTC"
                poolname="Cobra"
                />
                <div class="my-2" height="25"></div>
            <x-trophy-card
                username="Manny"
                pfp="https://ui-avatars.com/api/?rounded=false&name=Manny&size=128&background=f1c232"
                twitter="#"
                record="13-1"
                earnings="0.0017 BTC"
                poolname="Cobra"
                />
                <div class="my-2" height="25"></div>
            <x-trophy-card
                username="SDlefty"
                pfp="https://ui-avatars.com/api/?rounded=false&name=SDlefty&size=128&background=f1c232"
                twitter="#"
                record="13-1"
                earnings="0.0017 BTC"
                poolname="Cobra"
                />
            </div>
        </div>

        <div id="container" class="col h-full max-w-lg">
            <h1 class="block pb-2 tracking-wider underline decoration-slate-100 decoration-wavy underline-offset-4">2024-2025 Season</h1>
                <x-trophy-card
                username="SK"
                pfp="https://ui-avatars.com/api/?rounded=false&name=SK&size=128&background=f1c232"
                twitter="https://x.com/Grumpy_Raider"
                record="12-0"
                earnings="0.01 BTC"
                poolname="NBZ Bravo"
                />
        </div>
        <div id="container" class="col h-full max-w-lg">
            <h1 class="block pb-2 tracking-wider underline decoration-slate-100 decoration-wavy underline-offset-4">2023-2024 Season</h1>

            <x-trophy-card
                username="Roon3y"
                pfp="https://i.imgur.com/e1yjxWj.png"
                twitter="https://x.com/lie07"
                record="13-0"
                earnings="0.01 BTC"
                poolname="NBZ Alpha"
                />
        </div>

        
{{--
    <div id="container" class="col h-96 max-w-lg">
        <div class="w-full h-full">
            <h1 class="py-2">2024-2025 Season</h1>
            <div class="glass h-full w-full flex items-center justify-center text-center p-4">
                <div>

                </div>
            </div>
        </div>
    </div>
--}}
    </div>

    <h2 class="block py-2 tracking-wider font-semibold text-xl text-gray-200 leading-tight">
        Pick'em Legends
    </h2>
    <div class="flex flex-col md:space-y-4 lg:space-y-0 lg:grid lg:grid-cols-3 lg:gap-4 justify-center mx-4">

        <div id="container" class="col h-full max-w-lg">
            <h1 class="block pb-2 tracking-wider underline decoration-slate-100 decoration-wavy underline-offset-4">2025-2026 Season</h1>
                <div class="flex flex-col">
                <x-trophy-card
                username="XRSTOS13"
                pfp="https://pbs.twimg.com/profile_images/2004916234165362688/SeqF57kY_400x400.jpg"
                twitter="https://x.com/xrstos13"
                record="176-96"
                earnings="0.00108 BTC"
                poolname="NBZ Pick'em"
                />
                <div class="my-2" height="25"></div>
                <x-trophy-card
                username="Tdyck31"
                pfp="https://pbs.twimg.com/profile_images/657454507605921792/JkypxLCM_400x400.jpg"
                twitter="https://x.com/travisdyck"
                record="176-96"
                earnings="0.00108 BTC"
                poolname="NBZ Pick'em"
                />
            </div>
        </div>

        <div id="container" class="col h-full max-w-lg">
            <h1 class="block pb-2 tracking-wider underline decoration-slate-100 decoration-wavy underline-offset-4">2024-2025 Season</h1>
                <x-trophy-card
                username="MrSmurf65"
                pfp="https://pbs.twimg.com/profile_images/1162448925548326913/GNbcFaKA_400x400.jpg"
                twitter="https://x.com/MrSmurf65"
                record="181-89"
                poolname="NBZ Pick'em"
                />
        </div>

    

</x-app-layout>
