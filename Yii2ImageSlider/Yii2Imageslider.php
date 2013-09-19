<?php

 /**
 * This class is merely used to publish a TOC based upon the headings within a defined container
 * @copyright Frenzel GmbH - www.frenzel.net
 * @link http://www.frenzel.net
 * @author Philipp Frenzel <philipp@frenzel.net>
 *
 */

namespace Yii2Imageslider;

use Yii;
use yii\base\Model;
use yii\base\View;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\base\Widget as Widget;

class Yii2Imageslider extends Widget
{

    /**
    * @var array the HTML attributes (name-value pairs) for the field container tag.
    * The values will be HTML-encoded using [[Html::encode()]].
    * If a value is null, the corresponding attribute will not be rendered.
    */
    public $options = array(
        'class' => 'als-container',
    );


    /**
    * @var array all attributes that be accepted by the plugin, check docs!
    */
    public $clientOptions = array();

    /**
     * Initializes the widget.
     * If you override this method, make sure you call the parent implementation first.
     */
    public function init()
    {
        //checks for the element id
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }

        parent::init();
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        echo Html::beginTag('div', $this->options) . "\n";
            echo $this->renderControls('begin') . "\n";
            echo Html::beginTag('div', array('class'=>'als-viewport')) . "\n";
                echo $this->renderItems() . "\n";        
            echo Html::endTag('div') . "\n";
            echo $this->renderControls('end') . "\n";
        echo Html::endTag('div') . "\n";
        $this->registerPlugin();
    }

    /**
    * Registers a specific dhtmlx widget and the related events
    * @param string $name the name of the dhtmlx plugin
    */
    protected function registerPlugin()
    {
        $id = $this->options['id'];

        //get the displayed view and register the needed assets
        $view = $this->getView();
        Yii2ImageSliderAsset::register($view);

        $js = array();
        
        $className = $this->options['class'];
        
        $options = empty($this->clientOptions) ? '' : Json::encode($this->clientOptions);
        $js[] = "$('$className').tooltipster($options);";
        
        $view->registerJs(implode("\n", $js),View::POS_READY);
    }

    /**
     * Renders carousel items as specified on [[items]].
     * @return string the rendering result
     */
    public function renderItems()
    {
        $items = array();
        for ($i = 0, $count = count($this->items); $i < $count; $i++) {
            $items[] = $this->renderItem($this->items[$i], $i);
        }
        return Html::tag('div', implode("\n", $items), array('class' => 'als-wrapper'));
    }

    /**
     * Renders a single carousel item
     * @param string|array $item a single item from [[items]]
     * @param integer $index the item index as the first item should be set to `active`
     * @return string the rendering result
     * @throws InvalidConfigException if the item is invalid
     */
    public function renderItem($item, $index)
    {
        if (is_string($item)) {
            $content = $item;
            $caption = null;
        } elseif (isset($item['content'])) {
            $content = $item['content'];
            $caption = ArrayHelper::getValue($item, 'caption');
            if ($caption !== null) {
                $caption = Html::tag('div', $caption, array('class' => 'carousel-caption'));
            }            
        } else {
            throw new InvalidConfigException('The "content" option is required.');
        }

        Html::addCssClass($options, 'item');
        if ($index === 0) {
            Html::addCssClass($options, 'active');
        }

        return Html::tag('li', $content . "\n" . $caption, array('class'=>'als-item'));
    }

    /**
     * Renders previous and next control buttons.
     * @throws InvalidConfigException if [[controls]] is invalid.
     */
    public function renderControls($position='begin')
    {
        if ($position === 'begin')) {
            //<span class="als-prev"><img src="images/thin_left_arrow_333.png" alt="prev" title="previous" /></span>
            return  Html::beginTag('span',array('class'=>'als-prev')). "\n"
                    .Html::Tag('icon', array(
                        'class' => 'icon icon-arrow-left',
                        'title' => 'prev',
                    )) . "\n"
                    .Html::endTag('span'). "\n";
        } else {
            //<span class="als-next"><img src="images/thin_right_arrow_333.png" alt="next" title="next" /></span>
            return  Html::beginTag('span',array('class'=>'als-prev')). "\n"
                    .Html::Tag('icon', array(
                        'class' => 'icon icon-arrow-left',
                        'title' => 'prev',
                    )) . "\n"
                    .Html::endTag('span'). "\n";
        }
    }

}