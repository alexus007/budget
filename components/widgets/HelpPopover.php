<?php

namespace app\components\widgets;

use yii\bootstrap\Widget;
use yii\helpers\Html;

class HelpPopover extends Widget
{

    public $linkTag = 'a';
    public $dataOptions = [];

    public function init() {
        parent::init();
        $this->dataOptions['title'] = isset($this->dataOptions['title']) ? $this->dataOptions['title'] : '';
        $this->dataOptions['toggle'] = isset($this->dataOptions['toggle']) ? $this->dataOptions['toggle'] : 'popover';
        $this->dataOptions['placement'] = isset($this->dataOptions['placement']) ? $this->dataOptions['placement'] : 'right';
        $this->dataOptions['content'] = isset($this->dataOptions['content']) ? $this->dataOptions['content'] : '';
        $this->dataOptions['style'] = isset($this->dataOptions['style']) ? $this->dataOptions['style'] : '';

    }

    public function run() {
       echo Html::tag($this->linkTag, '<i class="fa fa-question-circle"></i>', [
            'data-title'=>$this->dataOptions['title'],
            'data-content'=>Html::decode($this->dataOptions['content']),
            'data-toggle'=>$this->dataOptions['toggle'],
            'style'=>$this->dataOptions['style'],
        ]);
    }

}