<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <h4>{{$country->name}}</h4>
    <ul>
        @foreach($airports as $airport)
            <li>{{$airport->name}}
                <span wire:click.prevent="deleteAirport('{{$airport->id}}')"
                      title="Delete">
                    Delete
                </span>
            </li>
        @endforeach
    </ul>
</div>
