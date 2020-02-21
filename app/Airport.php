<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sushi\Sushi;

/**
 * @method static find($airport_id)
 */
class Airport extends Model {

    use Sushi;

    protected array $rows = [
        ['id' => 1, 'code' => 'LHR', 'name' => 'Heathrow', 'country_id' => 4],
        ['id' => 2, 'code' => 'LGW', 'name' => 'Gatwick', 'country_id' => 4],
        ['id' => 3, 'code' => 'STN', 'name' => 'Stansted', 'country_id' => 4],
    ];

    /**
     * @return BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::Class);
    }

    public static function resetStatics()
    {
        static::setSushiConnection(null);
        static::clearBootedModels();
    }

    public static function setSushiConnection($connection)
    {
        static::$sushiConnection = $connection;
    }
}
