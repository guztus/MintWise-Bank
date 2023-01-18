<div class="heading-medium">Open a new account</div>
<form method="post" action="{{ route('account.create') }}">
    @csrf
    <div class="flex" style="justify-content: center;  align-items: center; column-gap: 0.5em;">
        <div class="flex" style="flex-direction: row">
            <input type="text"
                   name="label"
                   class="w-60 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-l-lg focus:ring-purple-800 focus:border-purple-800 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-800 dark:focus:border-purple-800"
                   placeholder="Account label" required>
            <select id="countries"
                    class="w-1/2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-r-lg focus:ring-purple-800 focus:border-purple-800 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-800 dark:focus:border-purple-800"
                    name="currency">
                @foreach($currencies as $currency => $rate)
                    <option value="{{ $currency }}">{{ $currency }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <input type="submit" class="btn" value="Submit">
        </div>
    </div>
</form>
