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
        if (YII_DEBUG) {
            $this->setupAssets('css', ['bootstrap-clockpicker.min.css']);
            $this->setupAssets('js', ['bootstrap-clockpicker.min.js']);
        } else {
            $this->setupAssets('css', ['bootstrap-clockpicker.css']);
            $this->setupAssets('js', ['bootstrap-clockpicker.js']);
        }
        parent::init();
    }
}
