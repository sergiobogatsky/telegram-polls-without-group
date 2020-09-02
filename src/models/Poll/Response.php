<?php

namespace Poll;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
