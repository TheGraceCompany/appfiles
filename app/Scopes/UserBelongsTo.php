<?php

/*
 * @author Phillip Madsen
 */

namespace App\Scopes;

/**
 * Class UserBelongsTo.
 *
 * @property int $user_id
 *
 * @method static $this getByUser(int $iUserID)
 */
trait UserBelongsTo
{
    public function scopeGetByUser($obQuery, $sData)
    {
        if (!empty($sData)) {
            $obQuery->where('user_id', $sData);
        }

        return $obQuery;
    }
}
