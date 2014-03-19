<?php
/**
 * @link http://www.frenzel.net/
 * @author Philipp Frenzel <philipp@frenzel.net> 
 */

namespace philippfrenzel\yii2imageslider;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class yii2imagesliderAsset extends AssetBundle
{
    public $sourcePath = '@yii2imageslider/assets';
    public $css = array(
        'css/als_default_style.css'
    );
    public $js = array(
        'js/jquery.als-1.2.min.js'
    );
    public $depends = array(
        'yii\web\JqueryAsset',
    );
}
