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

    <div class="container-fluid-fluid my-6" style="">
        <div class="center" style="width: 60%; height: 60%; text-align: center">
            <div>
                <h1 class="text-2xl font-bold">Transfer money</h1>
            </div>
            <x-message-or-error/>
            <div>
                <form method="POST" action="/transfer">
                    @csrf
                    {{--                                        <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Choose your account</label>--}}
                    <select id="account_number"
                            name="payerAccountNumber"
                            class="center w-50 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            style="width: 50%">
                        {{--                    <option selected>Choose your account</option>--}}
                        @foreach($accounts as $account)
                            <option
                                value="{{ $account->number }}">{{ $account->label }} ({{ $account->number }}
                                ) {{ number_format($account->balance/100, 2) }} {{ $account->currency }}</option>
                        @endforeach
                    </select>
                    <label>
                        <input type="text"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-l-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               name="beneficiaryAccountNumber" placeholder="Recipients Account Number"
                               required>
                    </label>
                    <label>
                        <input type="text"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-l-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               name="amount" placeholder="Amount" required>
                    </label>
                    <input type="text"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-l-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                           name="description" placeholder="Description" required>
                    <label>
                        <input type="text"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-l-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               name="code" placeholder="Code Nr. {{ $code }}" required>
                    </label>
                    <input type="submit" value="Send">
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
