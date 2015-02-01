# yii2-clockpicker
Yii 2 wrapper for Bootstrap clock-style timepicker; https://github.com/weareoutman/clockpicker

##Installation
To install, either run
```
$ php composer.phar require slatius\clockpicker "*"
```
or add
```
"slatius\clockpicker": "*"
```
to the require section of your composer.json file.

##Usage
```
use slatius\clockpicker\ClockPicker;

// Usage with ActiveForm and model
echo $form->field($model, 'time')->widget(ClockPicker::classname(), [
    'options' => [/* add some... */],
]);

// With model & without ActiveForm
echo ClockPicker::widget([
    'name' => 'this_time',
    'options' => [/* add some... */],
]);
```
