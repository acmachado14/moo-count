<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlertConfiguration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'frequency',
        'quantity_cattle',
    ];

    // Define a relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
