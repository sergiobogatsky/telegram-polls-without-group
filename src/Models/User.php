<?php


namespace SergioBogatsky\TelegramPollsWithoutGroup\Models;

class User extends \App\User
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function polls()
    {
        return $this->hasMany(Poll::class);
    }
}
