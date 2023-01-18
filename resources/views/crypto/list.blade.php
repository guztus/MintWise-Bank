<x-app-layout>
    <style>
        .percent-change {
        formatPercentage()
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
                    // place the arrow in front of the number
                    percentChange.textContent = "↑ + " + percentChange.textContent;
                    percentChange.style.color = "green";
                }
            }
        });
    </script>

    <div class="center" style="width: 60%; height: 60%; text-align: center">
        <div class="card-standard">
            <div class="heading">Cryptocurrency Market</div>
            <div class="mb-6">
                <form method="get" action="/crypto/search/">
                    <div class="flex px-32" style="justify-content: center; gap: 0.5em">
                        <input
                            class="input"
                            type="text"
                            name="symbol"
                            placeholder="Symbol">
                        <input type="submit" class="btn" value="Search">
                    </div>
                </form>
            </div>
            <table
                class="table-rounded center w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-2 py-2">Logo</th>
                    <th class="px-4 py-2">Symbol</th>
                    <th class="px-4 py-2">Price</th>
                    <th class="px-4 py-2">1h %</th>
                    <th class="px-4 py-2">24h %</th>
                    <th class="px-4 py-2">7d %</th>
                    <th class="px-4 py-2">24h Volume</th>
                    <th class="px-4 py-2">Volume %</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($cryptoList->getCoins() as $crypto)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-4 py-3">{{ $loop->index + 1 }}</td>
                        <td class="px-2 py-3"><img src="{{ $crypto->getLogo() }}" alt="icon"
                                                   style="display: block; margin-left: auto; margin-right: auto; width: 50%;">
                        </td>
                        <td class="px-4 py-3">
                            <a href="/crypto/{{ $crypto->getSymbol() }}">{{ $crypto->getSymbol() }}</a>
                        </td>
                        <td class="px-4 py-3">{{ $crypto->getPrice() }}</td>
                        <td class="px-4 py-3 percent-change"
                            data-percent-change="{{$crypto->getPercentChange1h()}}">
                        </td>
                        <td class="px-4 py-3 percent-change"
                            data-percent-change="{{$crypto->getPercentChange24h()}}">
                        </td>
                        <td class="px-4 py-3 percent-change"
                            data-percent-change="{{$crypto->getPercentChange7d()}}">
                        </td>
                        <td class="px-4 py-3">{{ $crypto->getVolume24h() }}</td>
                        <td class="px-4 py-3 percent-change"
                            data-percent-change="{{$crypto->getVolumeChange24h()}}">
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="flex text-xs pt-2 text-gray-500" style="justify-content: flex-end">Refreshed: {{ \Carbon\Carbon::parse(strtotime($cryptoList->getTimestamp()))->addHours(2)->format('M d-H:i:s') }}</div>
        </div>
    </div>
</x-app-layout>
