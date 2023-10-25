<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Comment extends Model
{
    use HasFactory;
    protected $table = "comments";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'client_id',
        'feedback_id',
        'content',
        'visible',
    ];

    /**
     * Relationship with clients table.
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    /**
     * Relationship with feedbacks table.
     */
    public function feedback()
    {
        return $this->belongsTo(Feedback::class, 'feedback_id');
    }

    /**
     * The convert created_at in human readable form.
     */
    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->diffForHumans();
    }

    /**
     * The convert updated_at in human readable form.
     */
    public function getUpdatedAtAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])->diffForHumans();
    }
}
