<div class="flex text-xs text-gray-500" style="justify-content: flex-end">Refreshed: {{ \Carbon\Carbon::parse(strtotime($crypto->getTimestamp()))->addHours(2)->format('M d-H:i:s') }}</div>
    <div class="flex items-center justify-center my-5">
        <img src="{{ $crypto->getLogo() }}" alt="icon">
    </div>
<div class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $crypto->getSymbol() }}</div>
<div class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
    € {{ number_format($crypto->getPrice(), 6) }}
    <span style="
                            font-size: 0.7em;
                            vertical-align: super" class="py-2 percent-change text-xs"
          data-percent-change="{{ $crypto->getPercentChange24h() }}"></span>
</div>

<div class="flex flex-col mt-8">
    <div class="flex">
        <p class="flex-1 px-4 py-2 bottom-gray-border left">Volume (24h)</p>
        <p class="flex-0 px-4 py-2 bottom-gray-border right">
            <span class="percent-change text-xs" data-percent-change="{{ $crypto->getVolumeChange24h() }}"></span>
        </p>
        <p class="flex-1 px-4 py-2 bottom-gray-border right">{{ $crypto->getVolume24h() }}</p>
    </div>

    <div class="flex">
        <p class="flex-1 px-4 py-2 bottom-gray-border left">Circulating Supply</p>
        <p class="flex-1 px-4 py-2 bottom-gray-border right">{{ $crypto->getCirculatingSupply() }}</p>
    </div>

    <div class="flex" >
        <p class="flex-1 px-4 py-2 bottom-gray-border left">Total Supply</p>
        <p class="flex-1 px-4 py-2 bottom-gray-border right">{{ $crypto->getTotalSupply() }}</p>
    </div>

    <div class="flex">
        <p class="flex-1 px-4 py-2 bottom-gray-border left">Max Supply</p>
        <p class="flex-1 px-4 py-2 bottom-gray-border right">{{ $crypto->getMaxSupply() }}</p>
    </div>
</div>
