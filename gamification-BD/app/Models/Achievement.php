<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'quest_id'
    ];

    public function quest()
    {
        return $this->belongsTo(Quest::class);
    }
}
