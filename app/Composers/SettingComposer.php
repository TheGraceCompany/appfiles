<?php

namespace App\Composers;

use App\Models\Setting;
use App\Repositories\Setting\SettingInterface;

/**
 * Class SettingComposer.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
class SettingComposer
{
    /**
     * @var \App\Repositories\Setting\SettingInterface
     */
    protected $setting;

    /**
     * @param SettingInterface $setting
     */
    public function __construct(SettingInterface $setting)
    {
        $this->setting = $setting;
    }

    /**
     * @param $view
     */
    public function compose($view)
    {
        $settings = $this->setting->getSettings();
        $view->with('settings', $settings);
    }
}
