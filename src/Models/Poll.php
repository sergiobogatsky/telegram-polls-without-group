<?php

namespace SergioBogatsky\TelegramPollsWithoutGroup\Models;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
