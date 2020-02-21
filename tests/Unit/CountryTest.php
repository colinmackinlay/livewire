<?php

namespace Tests\Unit;

use App\Airport;
use App\Country;
use App\Http\Livewire\CountryView;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Support\Facades\File;

/**
 * @property string cachePath
 */
class CountryTest extends TestCase {

    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();

        config(['sushi.cache-path' => $this->cachePath = __DIR__.'/cache']);

        Airport::resetStatics();
        Country::resetStatics();
        File::cleanDirectory($this->cachePath);
    }

    public function tearDown(): void
    {
        Airport::resetStatics();
        Country::resetStatics();
        File::cleanDirectory($this->cachePath);

        parent::tearDown();
    }

    /** @test */
    function it_shows_countries()
    {
        $this->get('/country')
            ->assertSee('Uganda')
            ->assertSee('United Kingdom');

    }

    /** @test */
    function it_shows_airports()
    {
        $this->get('/country/4')
            ->assertSee('Heathrow')
            ->assertSee('Gatwick');
    }

    /** @test */
    function livewire_shows_airports_and_country()
    {
        Livewire::test(CountryView::class, Country::where('code', 'GB')->first())
            ->assertSee('United Kingdom')
            ->assertSee('Heathrow')
            ->assertSee('Gatwick');
    }

    /** @test */
    function guests_cannot_delete_airports()
    {
        Livewire::test(CountryView::class, Country::where('code', 'GB')->first())
            ->assertSee('Heathrow')
            ->assertSee('Gatwick')
            ->call('deleteAirport', 1)
            ->assertSee('Heathrow')
            ->assertSee('Gatwick')
            ->assertForbidden();
    }

    /** @test */
    function users_can_delete_airports()
    {
        Livewire::actingAs(factory(User::class)->create())
            ->test(CountryView::class, Country::where('code', 'GB')->first())
            ->assertSee('Heathrow')
            ->assertSee('Gatwick')
            ->call('deleteAirport', 1)
            ->assertDontSee('Heathrow')
            ->assertSee('Gatwick');
    }

}
