<?php

/**
 * @copyright Copyright &copy; Arno Slatius, 2015
 * @package slatius/yii2-clockpicker
 */

namespace slatius\clockpicker;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;
use yii\web\View;

/**
 * Clockpicker widget is a Yii2 wrapper for the Bootstrap Clockpicker plugin by Wang Shenwei.
 * This input widget is a Bootstap based Android style time picker.
 *
 * @author Arno Slatius <a.slatius@gmail.com>
 * @see https://github.com/Hommer101/yii2-clockpicker
 * @see https://github.com/weareoutman/clockpicker
 */
class ClockPicker extends Widget
{
    /**
     * Initializes the widget
     *
     * @throw InvalidConfigException
     */
    public function init()
    {
        parent::init();
        $this->registerAssets();
    }

    /**
     * Renders the source Input for the Switch plugin.
     * Graceful fallback to a normal HTML checkbox or radio input
     * in case JQuery is not supported by the browser
     * @return string
     */
    protected function run()
    {
        return Html::tag('div', $output, $this->containerOptions) . "\n";
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        ClockPickerAsset::register($view);

        $this->pluginOptions['disabled'] = $this->disabled;
        $this->pluginOptions['readonly'] = $this->readonly;
        $id = $this->type == self::RADIO ? 'jQuery("[name = \'' . $this->name . '\']")' : 'jQuery("#' . $this->options['id'] . '")';

        $js = "{$tog}.on('click',function(){
    var \$el={$id}, val;
    \$el.bootstrapSwitch('toggleIndeterminate');
    val = \$el.prop('indeterminate') ? '{$this->indeterminateValue}' :
        (\$el.is(':checked').length > 0 ? 1 : 0);
    \$el.val(val);
});";
        $view->registerJs($js);
    }
}