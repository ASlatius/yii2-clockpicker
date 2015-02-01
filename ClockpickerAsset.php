<?php

/**
 * @copyright Copyright &copy; Arno Slatius, 2015
 * @package yii2-clockpicker
 */

namespace slatius\clockpicker;

/**
 * Asset bundle for Clockpicker Widget
 *
 * @author Arno Slatius <a.slatius@gmail.com>
 */
class ClockPickerAsset extends yii\web\AssetBundle
{
    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        $this->setupAssets('css', ['css/bootstrap-switch', 'css/bootstrap-switch-kv']);
        $this->setupAssets('js', ['js/bootstrap-switch']);
        parent::init();
    }
}
