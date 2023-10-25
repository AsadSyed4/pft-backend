<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Feedback extends Model
{
    use HasFactory;
    protected $table = "feedbacks";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'category',
        'vote_count',
        'client_id',
    ];

    /**
     * Relationship with clients table.
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    /**
     * Relationship with comments table.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'feedback_id');
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
