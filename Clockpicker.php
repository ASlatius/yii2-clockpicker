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
        if (empty($this->type) && $this->type !== self::CHECKBOX && $this->type !== self::RADIO) {
            throw new InvalidConfigException("You must define a valid 'type' which must be either 1 (for checkbox) or 2 (for radio).");
        }
        if ($this->type == self::RADIO) {
            if (empty($this->items) || !is_array($this->items)) {
                throw new InvalidConfigException("You must setup the 'items' array for the 'radio' type.");
            }
        }
        $this->registerAssets();
        echo $this->renderInput();
    }

    /**
     * Renders the source Input for the Switch plugin.
     * Graceful fallback to a normal HTML checkbox or radio input
     * in case JQuery is not supported by the browser
     * @return string
     */
    protected function renderInput()
    {
        if ($this->type == self::CHECKBOX) {
            if (empty($this->options['label'])) {
                $this->options['label'] = null;
            }
            $input = $this->getInput('checkbox');
            $output = ($this->inlineLabel) ? $input : Html::tag('div', $input);
            $output = $this->mergeIndToggle($output);
            return Html::tag('div', $output, $this->containerOptions) . "\n";
        }
        $output = '';
        Html::addCssClass($this->containerOptions, 'kv-switch-container');
        foreach ($this->items as $item) {
            if (!is_array($item)) {
                continue;
            }
            $label = ArrayHelper::getValue($item, 'label', false);
            $options = ArrayHelper::merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));
            $labelOptions = ArrayHelper::merge($this->labelOptions, ArrayHelper::getValue($item, 'labelOptions', []));
            $value = ArrayHelper::getValue($item, 'value', null);
            $options['value'] = $value;
            $input = Html::radio($this->name, ($value == $this->value), $options);

            $output .= Html::label($label, $this->name, $labelOptions) . "\n" .
                (($this->inlineLabel) ? $input : Html::tag('div', $input)) . "\n" .
                $this->separator;
        }
        return Html::tag('div', $output, $this->containerOptions) . "\n";
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        SwitchInputAsset::register($view);
        if (empty($this->pluginOptions['animate'])) {
            $this->pluginOptions['animate'] = true;
        }
        $this->pluginOptions['indeterminate'] = (
            $this->tristate &&
            $this->value === $this->indeterminateValue &&
            $this->type !== self::RADIO
        );
        $this->pluginOptions['disabled'] = $this->disabled;
        $this->pluginOptions['readonly'] = $this->readonly;
        $id = $this->type == self::RADIO ? 'jQuery("[name = \'' . $this->name . '\']")' : 'jQuery("#' . $this->options['id'] . '")';
        $this->registerPlugin($this->pluginName, $id);
        if (!$this->tristate || $this->indeterminateToggle === false || $this->type == self::RADIO) {
            return;
        }
        $tog = 'jQuery("[data-kv-switch=\'' . $this->options['id'] . '\']")';
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