<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'docent',
    ];

    public function quests()
    {
        return $this->hasMany(Quest::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
