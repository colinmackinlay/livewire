<div class="lg:w-1/3 md:w-1/2 px-3 pb-6">
    <div class="card card-default" style="height: 200px">
        <div class="card-header">{{ $header }}</div>

        <div class="card-body">
            <ul>
                @foreach($items as $item)
                    <li>
                        <a href="{{$item['url']}}">{{$item['text']}}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
