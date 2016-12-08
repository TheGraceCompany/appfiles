<?php

/*
 * @author Phillip Madsen
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    protected $fillable = ['name', 'email', 'user_id', 'message', 'subject', 'opened'];

    /**
     * @method user
     * @public
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(App\Models\User::class);
    }
}
