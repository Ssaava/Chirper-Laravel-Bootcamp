<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// import the belongs to relationship
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chirp extends Model
{
    use HasFactory;

    public function user(): BelongsTo 
    {
        return $this->belongsTo(User::class);
    }

    // add the relationship between the Chirp and its author

    // to enable mass assignment to the message
    protected $fillable = [
        'message'
    ];
}
