<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'location_id',
        'status',
        'total_price',
        'date_of_delivery',
    ];

    public function users(){
        return $this->hasMany(User::class, 'id');
    }

    public function location(){
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function items(){
        return $this->hasMany(OrderItem::class);
    }
}
