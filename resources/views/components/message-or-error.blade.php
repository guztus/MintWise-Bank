<div class="my-3">
    @if(session()->has("message_information"))
        <div
            class="p-4 center mb-4 text-md text-blue-700 bg-blue-100 rounded-lg dark:bg-blue-200 dark:text-blue-800"
            role="alert">
            <span class="font-medium">{{ Session::get("message_information") }}</span>
        </div>
    @elseif(session()->has('message_success'))
        <div
            class="p-4 center mb-4 text-md text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
            role="alert">
            <span class="font-medium">{{ Session::get("message_success") }}</span>
        </div>
    @elseif(session()->has('message_danger'))
        <div
            class="p-4 center mb-4 text-md text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800"
            role="alert">
            <span class="font-medium">{{ Session::get('message_danger') }}</span>
        </div>
    @endif
    @if ($errors->any())
        <div class="p-4 center mb-4 text-md text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800"
             role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
