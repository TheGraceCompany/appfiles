<?php



namespace App\Scopes;

/**
 * Created by PhpStorm.
 * User: Phillip
 * Date: 11/15/2016
 * Time: 1:06 PM.
 *
 * @property string $code
 *
 * @method static $this getByCode(string $sData)
 * @method static $this likeByCode(string $sData)
 * @method static $this nullCode()
 * @method static $this notNullCode()
 */
trait CodeSection
{
    /**
     * Get element by code value.
     *
     * @param \Illuminate\Database\Eloquent\Builder
     * @param string $sData
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGetByCode($obQuery, $sData)
    {
        if (!empty($sData)) {
            $obQuery->where('code', $sData);
        }

        return $obQuery;
    }

    /**
     * Get element like code value.
     *
     * @param \Illuminate\Database\Eloquent\Builder
     * @param string $sData
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLikeByCode($obQuery, $sData)
    {
        if (!empty($sData)) {
            $obQuery->where('code', 'like', '%'.$sData.'%');
        }

        return $obQuery;
    }

    /**
     * Get element with empty code.
     *
     * @param \Illuminate\Database\Eloquent\Builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNullCode($obQuery)
    {
        return $obQuery->whereNull('code');
    }

    /**
     * Get element with not empty code.
     *
     * @param \Illuminate\Database\Eloquent\Builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotNullCode($obQuery)
    {
        return $obQuery->whereNotNull('code');
    }
}
