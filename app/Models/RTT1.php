<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class RTT1 extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = '_r_t_t1';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'predicted_x_distance',
        'predicted_y_distance',
        'actual_x_distance',
        'actual_y_distance',
    ];

}
