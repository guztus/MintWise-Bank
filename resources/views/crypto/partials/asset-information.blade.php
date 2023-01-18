<div>
    {{--                display asset owned amount for this asset--}}
    @if ($assetOwned)
        <div class="mb-2 font-bold tracking-tight text-gray-900 dark:text-white">
            You own {{ $assetOwned->amount }} {{ $crypto->getSymbol() }}
        </div>
        <div class="mb-2 font-bold tracking-tight text-gray-900 dark:text-white">
            Average price: € {{ number_format($assetOwned->average_cost, 2) }}
        </div>
        <div class="mb-2 font-bold tracking-tight text-gray-900 dark:text-white">
            Total worth: € {{ number_format($assetOwned->amount * $crypto->getPrice(), 2) }}
        </div>
    @endif
</div>
