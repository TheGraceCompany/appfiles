<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Setting.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
class Setting extends Model
{
    public $table = 'settings';
    public $fillable = ['settings', 'lang'];
}
