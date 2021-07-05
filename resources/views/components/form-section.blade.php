<div {{$attributes->merge(["class" => "md:grid md:grid-cols-3 md:gap-6"])}}>
    <div class="px-4 sm:px-0">
        <h3 class="text-lg font-medium text-gray-900">
            {{$title}}
        </h3>

        <p class="mt-1 text-sm text-gray-600">
            {{$description}}
        </p>
    </div>

    <div class="mt-5 md:mt-0 md:col-span-2">
        <div>
            <div class="px-4 py-5 sm:p-6 bg-white shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
                {{$slot}}
            </div>

            @isset($actions)

                <div class="px-6 py-3 bg-gray-100 shadow flex justify-end items-center sm:rounded-bl-md sm:rounded-br-md">
                    {{$actions}}
                </div>

            @endisset
            
        </div>
    </div>
</div>