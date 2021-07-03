<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CarUsage
 * @package App\Models
 *
 * @property Carbon $time_from
 * @property Carbon $time_to
 * @property int $user_id
 * @property int $car_id
 *
 * @property-read Car $car
 * @property-read User $user
 */
class CarUsage extends Model
{
    protected $fillable = ['time_from', 'time_to', 'user_id', 'car_id'];
    protected $table = 'car_usage';

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
