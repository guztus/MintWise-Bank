<script>

    function openModal () {
        let floatingDiv = document.getElementById("floating-div");

        try {
            console.log('action');
            if (floatingDiv.style.display === "none") {
                floatingDiv.style.display = "block";
            } else {
                floatingDiv.style.display = "none";
            }
        } catch (error) {
            console.error(error);
        }
    }
    window.onload = function () {
        const inputAmount = document.getElementById('currency-input');
        const switchCurrency = document.getElementById('currency-switch');
        const selectFrom = document.getElementById('currency-from');
        const selectTo = document.getElementById('currency-to');
        const result = document.getElementById('result');

        switchCurrency.addEventListener('click', function () {
            const fromRate = selectFrom.value;
            const toRate = selectTo.value;
            const amount = inputAmount.value;

            selectFrom.value = toRate;
            selectTo.value = fromRate;
            result.textContent = (amount * fromRate / toRate).toFixed(2);
        });

        selectFrom.addEventListener('change', function () {
            calculateRates();
        });

        selectTo.addEventListener('change', function () {
            calculateRates();
        });

        inputAmount.addEventListener('input', function () {
            calculateRates();
        });

        function calculateRates() {
            const fromRate = selectFrom.value;
            const toRate = selectTo.value;
            const amount = inputAmount.value;

            result.textContent = (amount * toRate / fromRate).toFixed(2);
        }

        calculateRates();
    }
</script>

<div class="fixed bottom-0 right-0 mb-6 mr-8 z-50">
    <button class="bg-purple-900 transition duration-150 ease-in-out p-2 rounded-full hover:bg-purple-600" id="open-div" onclick="openModal()">
        <i class="fas fa-plus">
            <svg fill="#FFFFFF" height="35px" width="35px" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 273.835 273.835" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 273.835 273.835">
                <g>
                    <path d="m273.835,116.316c0-38.584-31.39-69.974-69.974-69.974-23.486,0-44.29,11.642-56.988,29.446-5.7-1.215-11.6-1.884-17.641-1.953-5.787-30.073-32.286-52.867-64.022-52.867-35.958,3.55271e-15-65.21,29.253-65.21,65.21 0,27.13 16.658,50.435 40.279,60.246-1.053,5.482-1.611,11.137-1.611,16.921 0,49.363 40.16,89.522 89.522,89.522 41.754,0 76.92-28.734 86.77-67.466 33.327-5.336 58.875-34.278 58.875-69.085zm-145.645,126.551c-43.849,0-79.522-35.674-79.522-79.522s35.674-79.522 79.522-79.522 79.522,35.674 79.522,79.522-35.673,79.522-79.522,79.522zm-66.78-211.771c28.011-1.885 51.985,17.263 57.703,43.183-14.305,1.447-27.625,6.275-39.148,13.671 0-0.793-0.643-1.436-1.436-1.436h-5.478l10.905-21.868c1.989-3.989-0.912-8.678-5.37-8.678-2.275,0-4.354,1.287-5.37,3.323l-8.007,16.058-8.007-16.058c-1.015-2.036-3.095-3.323-5.37-3.323-4.458,0-7.359,4.689-5.37,8.678l10.905,21.868h-3.774c-1.734,0-3.139,1.406-3.139,3.139v0.116c0,1.734 1.406,3.139 3.139,3.139h19.4c-1.233,0.968-2.437,1.97-3.617,3h-15.783c-1.734,0-3.139,1.406-3.139,3.139 0,1.734 1.406,3.139 3.139,3.139h9.284c-0.918,0.98-1.815,1.98-2.689,3l-.979,1.157c-7.304,8.824-12.95,19.067-16.458,30.247-20.083-8.982-33.866-29.603-32.68-53.244 1.392-27.741 23.622-50.384 51.339-52.25zm155.566,120.747c0.597,0.053 1.192,0.084 1.784,0.084 2.215,0 4.447-0.369 6.822-1.128 0.153-0.049 0.305-0.099 0.456-0.15 2.861-0.965 4.246-4.208 3-6.958l-.682-1.506c-1.1-2.428-3.845-3.645-6.383-2.831l-.04,.013c-2.356,0.752-3.986,0.752-6.346,0-0.408-0.13-0.832-0.288-1.263-0.457-1.948-6.859-4.7-13.383-8.14-19.469h5.406c2.001,0 3.623-1.622 3.623-3.623 0-2.001-1.622-3.623-3.623-3.623h-9.971c-2.551-3.65-5.364-7.104-8.416-10.33-0.006-0.013-0.011-0.026-0.017-0.039-0.318-6.571 4.936-12.019 11.439-12.019 4.967,0 9.206,3.179 10.789,7.609 0.835,2.337 3.116,3.844 5.597,3.844 4.109,0 7.079-4.064 5.686-7.93-3.258-9.041-11.923-15.523-22.073-15.523-9.841,0-18.28,6.095-21.755,14.706-7.661-5.928-16.304-10.643-25.641-13.854 11.607-14.346 29.677-23.259 49.745-22.238 30.856,1.57 55.733,26.861 56.823,57.737 1.041,29.508-19.368,54.517-46.818,60.669 0.484-3.761 0.734-7.594 0.734-11.484 0.001-3.895-0.251-7.734-0.736-11.5z"/>
                    <path d="m114.665,181.796c0-3.361-2.725-6.087-6.087-6.087-3.361,0-6.087,2.725-6.087,6.087 0,12.073 8.371,22.223 19.612,24.964v3.271c0,3.361 2.725,6.087 6.087,6.087 3.362,0 6.087-2.725 6.087-6.087v-3.271c11.241-2.741 19.612-12.891 19.612-24.964s-8.371-22.222-19.612-24.964v-26.322c4.406,2.232 7.439,6.795 7.439,12.062 0,3.361 2.725,6.087 6.087,6.087s6.087-2.725 6.087-6.087c0-12.073-8.371-22.223-19.612-24.964v-3.271c0-3.361-2.725-6.087-6.087-6.087-3.362,0-6.087,2.725-6.087,6.087v3.271c-11.241,2.741-19.612,12.891-19.612,24.964s8.371,22.223 19.612,24.964v26.322c-4.406-2.232-7.439-6.794-7.439-12.062zm27.051,0c0,5.268-3.033,9.83-7.439,12.062v-24.124c4.405,2.232 7.439,6.795 7.439,12.062zm-27.051-39.224c0-5.267 3.033-9.83 7.439-12.062v24.124c-4.406-2.232-7.439-6.794-7.439-12.062z"/>
                </g>
            </svg>
        </i>
    </button>
</div>

<div class="fixed right-3 bottom-0 mr-3 mb-4 border-2 fixed bg-white p-5 rounded-lg" id="floating-div" style="display: none; width: 250px; height: 350px;">
    <div class="relative flex flex-col center items-center">
        <button id="currency-switch" class="absolute left-0 top-1/2">
            <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M6 19L3 16M3 16L6 13M3 16H11C12.6569 16 14 14.6569 14 13V12M10 12V11C10 9.34315 11.3431 8 13 8H21M21 8L18 11M21 8L18 5" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
        <label>Amount
            <input
                type="number"
                id="currency-input"
                class="input w-36"
                placeholder="Amount"
                min="0"
                step=".01"
                value="1.00"
            >
        </label>

        <label> Currency from
            <select id="currency-from" class="input w-28">
                @foreach(Cache::get('currencies') as $currency => $rate)
                    <option
                        value="{{ $rate }}"
                    >
                        {{ $currency }}
                    </option>
                @endforeach
            </select>
        </label>

        <label> Currency to
            <select id="currency-to" class="input w-28">
                @foreach(Cache::get('currencies') as $currency => $rate)
                    <option
                        selected
                        value="{{ $rate }}"
                    >
                        {{ $currency }}
                    </option>
                @endforeach
            </select>
        </label>

        <label>Result
            <p id="result" class="left w-36 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-900 focus:border-purple-900 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500">
                1.00
            </p>
        </label>

        <p id="currency-rates-description"></p>

    </div>
</div>
