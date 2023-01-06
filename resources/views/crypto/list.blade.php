<x-app-layout>
    <style>
        .center {
            margin-left: auto;
            margin-right: auto;
        }

        .left {
            text-align: left;
        }

        .right {
            text-align: right;
        }
    </style>

    <div class="container-fluid-fluid" style="margin-right: 0">
        <div class="center" style="width: 50%; height: 50%; text-align: center">
            <div>
                <h1 class="text-2xl font-bold">Crypto</h1>
            </div>
            <div>
                {{--                from cryptoList using foreach show  symbol, max_supply, circulation_supply, total_supply, --}}
                <table class="table-auto">
                    <thead>
                    <tr>
                        <th class="px-4 py-2">Symbol</th>
                        <th class="px-4 py-2">Icon</th>
                        <th class="px-4 py-2">Max Supply</th>
                        <th class="px-4 py-2">Circulation Supply</th>
                        <th class="px-4 py-2">Total Supply</th>
                        <th class="px-4 py-2">Price</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cryptoList as $crypto)
                        <tr>
                            <td class="border px-4 py-2"><a
                                    href="/crypto/{{ $crypto->getSymbol() }}">{{ $crypto->getSymbol() }}</a></td>
                            <td class="border px-4 py-2"><img src="{{ $crypto->getLogo() }}" alt="icon"></td>
                            <td class="border px-4 py-2">{{ $crypto->getMaxSupply() }}</td>
                            <td class="border px-4 py-2">{{ $crypto->getCirculatingSupply() }}</td>
                            <td class="border px-4 py-2">{{ $crypto->getTotalSupply() }}</td>
                            <td class="border px-4 py-2">{{ $crypto->getPrice() }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
