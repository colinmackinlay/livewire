<div class="alert-{{session('alert')['type']}}">
    {{--    <strong class="font-bold">{{ $title }}</strong>--}}
    <span class="block sm:inline">{{ session('alert')['message'] }}</span>
</div>
