<?php

namespace SergioBogatsky\TelegramPollsWithoutGroup\models\Poll;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function user()
    {
        return $this->belongsTo(Poll::class);
    }
    public function responses()
    {
        return $this->hasMany(Response::class);
    }
}
