<x-app-layout>
    <style>
        /* Style inputs */
        input[type=number], select {
            width: 95%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
        }

         .bottom-gray-border {
             border-bottom: solid 1px;
             border-color: lightgray
         }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let percentChanges = document.getElementsByClassName("percent-change");

            for (let i = 0; i < percentChanges.length; i++) {
                let percentChange = percentChanges[i];
                let percentValue = percentChange.getAttribute("data-percent-change");
                percentChange.textContent = Math.abs(parseFloat(percentValue)).toLocaleString('en-US', {
                    maximumFractionDigits: 2,
                    useGrouping: true
                }) + "%";
                if (percentValue < 0) {
                    percentChange.textContent = "↓ - " + percentChange.textContent;
                    percentChange.style.color = "red";
                } else {
                    percentChange.textContent = "↑ + " + percentChange.textContent;
                    percentChange.style.color = "green";
                }
            }
        });
    </script>

    <div class="center" style="width: 60%; height: 60%; text-align: center">
        <x-message-or-error/>
        <div>
            <div class="center card-standard w-2/5 px-4 pt-4">
                @include('crypto.partials.crypto-information')
                @include('crypto.partials.asset-information')
            </div>
        </div>
        @include('crypto.partials.buy-sell-form')
        @include('layouts.transactions', ['identifier' => 'Crypto'])
    </div>
</x-app-layout>
