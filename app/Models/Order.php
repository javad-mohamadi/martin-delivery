<?php

namespace App\Models;

use App\Casts\DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'status',
        'provider_name',
        'provider_mobile',
        'provider_address',
        'provider_latitude',
        'provider_longitude',
        'receiver_name',
        'receiver_mobile',
        'receiver_address',
        'receiver_latitude',
        'receiver_longitude',
    ];


    /**
     * @var string[]
     */
    protected $casts = [
        'created_at' => DateTime::class,
        'updated_at' => DateTime::class,
    ];


    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
