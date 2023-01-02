<x-app-layout>
    <script>
        window.onload = function randomNumber() {
            // console.log('test')
            let randomNumber = Math.ceil(Math.random() * 12);
            document.getElementById('codeId').value = randomNumber
            document.getElementById('codeId').placeholder = randomNumber
        }
    </script>

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
        input[type=text], select {
            width: 50%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        /* Style the submit button */
        input[type=submit] {
            width: 50%;
            background-color: #04AA6D;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Add a background color to the submit button on mouse-over */
        input[type=submit]:hover {
            background-color: #45a049;
        }
    </style>

    <div class="container-fluid-fluid" style="">
        <div class="center" style="width: 50%; height: 50%; text-align: center">
            <div>
                <h1 class="text-2xl font-bold">Transfer money</h1>
            </div>

            <div>
                @if(session()->has('message'))
                    <div
                        class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
                        role="alert">
                        <span class="font-medium">{{ session()->get('message') }}</span>
                    </div>
                @endif
            </div>


            <div>
                <form method="POST" action="/transfer/confirm">
                    @csrf
                    <label>
                        <input type="text" name="name" placeholder="Recipients Name" required>
                    </label>
                    <label>
                        <input type="text" name="beneficiary_account_number" placeholder="Recipients Account Number"
                               required>
                    </label>
{{--                                        <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Choose your account</label>--}}
                    <select id="countries"
                            name="account_selected"
                            class="center w-50 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            style="width: 50%">
                        {{--                    <option selected>Choose your account</option>--}}
                        @foreach($accounts as $account)
                            <option
                                value="{{ $account->id }}">{{ $account->name }} {{ $account->number }} {{ number_format($account->balance/100, 2) }} {{ $account->currency }}</option>
                        @endforeach
                    </select>
                    <label>
                        <input type="text" name="amount" placeholder="Amount" required style="width: 40%">
                    </label>
                    <label for="underline_select" class="sr-only">Underline select</label>
                    <select id="underline_select"
                            name="currency_selected"
                            class="center  py-2.5 px-0 w-10 text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer"
                            style="width: 10%">
                        <option value="US-DOLLAR">US Dollar</option>
                        <option value="EUR" selected>EUR</option>
                        <option value="GBP">GBP</option>
                        <option value="YEN">YEN</option>
                        <option value="ZLOTY">ZLOTY</option>
                    </select>
                    <label>
                        <input type="text" name="code" placeholder="Code" required>
                        <input id="codeId" name="codeId" value="" placeholder=""
                               style="width: 20px !important;">
                    </label>
                    <input type="text" name="description" placeholder="Description" required>
                    <input type="submit" value="Send">
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
