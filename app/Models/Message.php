<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

class Message extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function chatroom(): BelongsTo
    {
        return $this->belongsTo(Pool::class, 'pool_chat_id');
    }

    public function from(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from_id');
    }

    public function survivor()
    {
        return $this->hasOne(SurvivorRegistration::class, 'pool_id', 'pool_chat_id')->where('user_id', $this->from_id);
    }

    public function getIsAliveAttribute(): bool
    {
        return $this->survivor?->alive ?? false;
    }

    public function isMine(): bool
    {
        return $this->from_id === auth()->id();
    }

    public function isPreviousFromAnotherPerson(Collection $messages, mixed $loop): bool
    {
        return ($loop->index === 0 || $this->from_id !== $messages[$loop->index - 1]->from_id);
    }

    public function isNextFromSamePerson(Collection $messages, mixed $loop): bool
    {
        return ! $loop->last && ($this->from_id === $messages[$loop->index + 1]->from_id);
    }
}
