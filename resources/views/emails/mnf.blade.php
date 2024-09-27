<x-layouts.email>

    <div class="max-w-lg mx-auto p-6 bg-white shadow-md rounded-lg">

        <!-- Main Content -->
        <div class="mb-6">
            <p class="mb-4">Coach {{$name}},</p>
            <p>
            I hope this message finds you in good spirits, but I <b>must</b> cut to the chase with the urgency of a last-second field goal attempt. 
            <br>
            <br>
            You're still alive with 1 game left on the board. Whose it going to be Coach? Atlanta Falcons or Philadelphia Eagles on MNF. We're just 2 hours~ til kickoff. 
            <br>
            <br>
            </p>
            <p>
                Think of this as the ultimate coaching challenge. Your legacy, your very existence, hinges on the wisdom of your choice. Will you go for the safe bet, or will you roll the dice on an underdog with everything to prove?
                <br>
                <br>
                Act now, Coach! The clock is ticking faster than a two-minute drill. Your team needs you to step up, make a decision, and lead them to victory. Or, you know, just lead them. Period.
                <br>
                <br>
                Don't let this be the season where they write, "Here lies Coach {{$name}}, who forgot to pick a team." 
                <br>
                <br>
                Best of luck, and may your chosen team play like they've got more than just a game on the line.
            </p>
            <p class="text-center">
                <a href="{{ $link }}" class="button button-success">Select your pick</a>
            </p>
        </div>

        <!-- Footer -->
        <div class="text-center text-gray-600">
            <p class="mb-2">Yours in gridiron glory,
            <br>
            BB
            <br>
            Commissioner of the NFL Survival League
            </p>
            <a style="color: #b0adc5; font-size: 12px;" class="text-xs" href="{{ $unsubscribelink }}">Unsubscribe?</a>
        </div>
    </div>

</x-layouts.email>