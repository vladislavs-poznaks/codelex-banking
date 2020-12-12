<x-app-layout>
    <div class="flex">
        <div class="flex w-1/4">
            {{--            @include('sidebars._nav')--}}
        </div>

        <div class="w-1/2">
            @yield('content')
        </div>

        <div class="flex w-1/4 ml-20">
            {{--            @include('sidebars._recent-transactions')--}}
        </div>
    </div>
</x-app-layout>
