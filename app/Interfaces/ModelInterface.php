<?php

namespace App\Interfaces;

/**
 * Class ModelInterface.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
interface ModelInterface
{
    /**
     * @param $value
     *
     * @return mixed
     */
    public function setUrlAttribute($value);

    /**
     * @return mixed
     */
    public function getUrlAttribute();
}
