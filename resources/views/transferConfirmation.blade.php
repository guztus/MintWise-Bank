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
{{--            {{ $transfer->code }}--}}
            <div>
                <h1 class="text-2xl font-bold">Transfer money</h1>
            </div>
            <form method="POST" action="/transfer/confirm">
                @csrf
                <label>
                    <input type="text" name="amount" placeholder="Code " required>
                </label>
                <input type="submit">
            </form>
        </div>
    </div>
</x-app-layout>
