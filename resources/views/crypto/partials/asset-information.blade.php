@if ($assetOwned)
    <p class="mt-10 font-semibold">Asset information</p>
    <div style="border-top: solid 1px; border-color: gray">
        <div class="flex flex-col mt-2">
            <div class="flex">
                <p class="flex-1 px-4 py-2 bottom-gray-border left">You own</p>
                <p class="flex-1 px-4 py-2 bottom-gray-border right">{{ (float)$assetOwned->amount }} {{ $crypto->getSymbol() }}</p>
            </div>
            <div class="flex">
                <p class="flex-1 px-4 py-2 bottom-gray-border left">Average price:</p>
                <p class="flex-1 px-4 py-2 bottom-gray-border right">{{ config('global.currency_symbol') }} {{ number_format($assetOwned->average_cost, 2) }}</p>
            </div>
            <div class="flex">
                <p class="flex-1 px-4 py-2 bottom-gray-border left">Total worth:</p>
                <p class="flex-1 px-4 py-2 bottom-gray-border right">{{ config('global.currency_symbol') }} {{ number_format($assetOwned->amount * $crypto->getPrice(), 2) }}</p>
            </div>
        </div>
</div>
@endif
