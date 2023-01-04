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

        /* Style inputs */
        input[type=number], select {
            width: 95%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
    </style>

    <div class="container-fluid-fluid" style="">
        <div class="center" style="width: 50%; height: 50%; text-align: center">
            <table class="table-auto center">
                <thead>
                <tr>
                    <th class="px-4 py-2">Symbol</th>
                    <th class="px-4 py-2">Average Cost</th>
                    <th class="px-4 py-2">Amount</th>
                </tr>
                </thead>
                <tbody>
                @foreach($assets as $asset)
                    <tr>
                        <td class="px-4 py-2">{{ $asset->symbol }}</td>
                        <td class="px-4 py-2">{{ $asset->average_cost_before_decimal . "." . $asset->average_cost_after_decimal }}</td>
                        <td class="px-4 py-2">{{ $asset->amount_before_decimal . "." . $asset->amount_after_decimal }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
