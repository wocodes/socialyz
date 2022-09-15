<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    public $fillable = [
        "user_id",
        "title",
        "description",
        "number_of_participants",
        "date",
        "location",
        "location_detail",
        "requirements",
        "payer",
        "slots_left"
    ];

    public $casts = [
        "requirements" => "json"
    ];

    public function participants()
    {
        return $this->hasMany(EventParticipant::class);
    }

    public function messages()
    {
        return $this->hasMany(EventMessage::class);
    }

    public function userHasJoined()
    {
        return $this->participants()->where('user_id', auth()->user()->id)->exists();
    }
}
