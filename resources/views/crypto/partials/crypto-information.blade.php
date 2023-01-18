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

<div>
    <table class="table-rounded table-auto right">
        <thead>
        <tr>
            <th class="px-4 py-2">Volume (24h)</th>
            <td class="border px-4 py-2">
                <span class="px-4 py-2 percent-change text-xs" data-percent-change="{{ $crypto->getVolumeChange24h() }}"></span>
                {{ $crypto->getVolume24h() }}
            </td>
        </tr>
        <tr>
            <th class="px-4 py-2">Circulating Supply</th>
            <td class="border px-4 py-2">{{ $crypto->getCirculatingSupply() }}</td>
        </tr>
        <tr>
            <th class="px-4 py-2">Total Supply</th>
            <td class="border px-4 py-2">{{ $crypto->getTotalSupply() }}</td>
        </tr>
        <tr>
            <th class="px-4 py-2">Max Supply</th>
            <td class="border px-4 py-2">{{ $crypto->getMaxSupply() }}</td>
        </tr>
        </thead>
    </table>
</div>
