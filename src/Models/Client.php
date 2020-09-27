<?php


namespace SergioBogatsky\TelegramPollsWithoutGroup\Models;

class Client extends \App\Client
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function responses()
    {
        return $this->belongsToMany(Response::class)->withPivot('sort_position')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function questions()
    {
        return $this->belongsToMany(Question::class)->withTimestamps();
    }
}
