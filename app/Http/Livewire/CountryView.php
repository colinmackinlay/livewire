<?php

namespace App\Http\Livewire;

use App\Airport;
use App\Country;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class CountryView extends Component {

    use AuthorizesRequests;

    public $country;

    public function render()
    {
        $airports = $this->country->fresh()->airports;
        if (auth()->user())
        {
            $name = auth()->user()->name;
        } else
        {
            $name = 'null';
        }

        info("Auth user in render method: " . $name);

        return view('livewire.country-view', compact('airports'));
    }

    public function deleteAirport($airport_id)
    {
        info("Request delete airport with id $airport_id");
        if (auth()->user())
        {
            $name = auth()->user()->name;
        } else
        {
            $name = 'null';
        }

        info("Auth user in deleteAirport method: " . $name);
        $this->authorize('update', $this->country);

        if (Airport::find($airport_id)->country_id != $this->country->id) return;

        Airport::destroy($airport_id);
//        simulate delete with info message
//        CURRENTLY REVERTED TO ACTUAL DELETE FOR PHPUNIT TESTS
        info("Delete airport with id $airport_id");

    }

    public function mount(Country $country)
    {
        if (auth()->user())
        {
            $name = auth()->user()->name;
        } else
        {
            $name = 'null';
        }
        info("Auth user when mounted: " . $name);
        $this->country = $country;
    }
}
