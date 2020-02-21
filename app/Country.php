<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class Country extends Model {

    use Sushi;

    protected array $rows = [
        ['id' => 1, 'code' => 'UG', 'code3' => 'UGA', 'name' => 'Uganda', 'number' => '800'],
        ['id' => 2, 'code' => 'UA', 'code3' => 'UKR', 'name' => 'Ukraine', 'number' => '804'],
        ['id' => 3, 'code' => 'AE', 'code3' => 'ARE', 'name' => 'United Arab Emirates (the)', 'number' => '784'],
        ['id' => 4, 'code' => 'GB', 'code3' => 'GBR', 'name' => 'United Kingdom of Great Britain and Northern Ireland (the)', 'number' => '826'],
        ['id' => 5, 'code' => 'UM', 'code3' => 'UMI', 'name' => 'United States Minor Outlying Islands (the)', 'number' => '581'],
    ];

    public function airports()
    {
        return $this->hasMany(Airport::class);
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
