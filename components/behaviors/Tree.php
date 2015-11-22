<?php

namespace app\components\behaviors;

use Yii;
use yii\base\Behavior;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Tree extends Behavior
{

    public $primaryKeyAttribute = 'id';

    /**
        * @var string model attr
        */
    public $parentAttribute = 'parent_id';

    /**
        * @var callable parent relation
        */
    public $parentRelation = 'parent';

    /**
        * @var array default criteria for all queries
        */
    public $defaultCriteria;

    /**
        *@var string model attribute used for showing title
        */
    public $titleAttribute = 'title';

    /**
        * @var string model property, which contains url.
        * Optionally your model can have 'url' attribute or getUrl() method,
        * which construct correct url for using our getMenuList().
        */
    public $urlAttribute = 'url';

    /**
        * @var string model attribute, which defined alias
        */
    public $aliasAttribute = 'alias';



    public function init()
    {
        parent::init();
    }

    public function events()
    {
        return [
        ];
    }


    public function getArray()
    {
        $query = $this->getDefaultCriteria();
        $query->select([$this->primaryKeyAttribute]);
        return ArrayHelper::getColumn($query->all(),$this->owner->{$this->primaryKeyAttribute});
    }

    public function getAssocList()
    {
        $query = $this->getDefaultCriteria();
        return ArrayHelper::map($query->all(),$this->primaryKeyAttribute, $this->titleAttribute);
    }

    public function getMenuList()
    {
        $query = $this->getDefaultCriteria();
        $items = $query->all();
        $result = [];
        foreach($items as $item) {
            $pk = ArrayHelper::getValue($item,$this->primaryKeyAttribute);
            $result[$pk] = [
                'id'    => $pk,
                'label' => $item->{$this->titleAttribute},
                'url'   => $item->{$this->urlAttribute}
            ];
        }
        return $result;
    }

    public function isChildOf($parent)
    {
        if (is_int($parent) && $this->owner->getPrimaryKey() == $parent)
            return false;

        $parents = $this->arrayFromArgs($parent);

        $model = $this->owner;

        $i = 50;

        while ($i-- && $model){
            if (in_array($model->getPrimaryKey(), $parents))
                return true;
            $model = $model->{$this->parentRelation};
        }
        return false;
    }

    public function getChildsArray($parent = null)
    {
        $parents = $this->processParents($parent);

        $criteria = $this->getDefaultCriteria();
        $criteria->select([$this->primaryKeyAttribute, $this->titleAttribute, $this->parentAttribute]);
        $items = $criteria->all();

        $result = array();

        foreach ($parents as $parent_id){
            $this->_childsArrayRecursive($items, $result, $parent_id);
        }

        return array_unique($result);

    }

    protected function _childsArrayRecursive(&$items, &$result, $parent_id)
    {
        foreach ($items as $item){
            if ((int)$item[$this->parentAttribute] == (int)$parent_id){
                $result[] = $item[$this->primaryKeyAttribute];
                $this->_childsArrayRecursive($items, $result, $item[$this->primaryKeyAttribute]);
            }
        }
    }

    public function getTreeAssocList($parent=0)
    {

        $items = $this->getFullAssocData(array(
            $this->primaryKeyAttribute,
            $this->titleAttribute,
            $this->parentAttribute,
        ), $parent);

        $associated = array();
        foreach ($items as $item){
            $associated[$item[$this->primaryKeyAttribute]] = $item;
        }
        $items = $associated;

        $result = array();

        foreach($items as $item){
            $titles = array($item[$this->titleAttribute]);

            $temp = $item;
            while (isset($items[(int)$temp[$this->parentAttribute]])){
                $titles[] = $items[(int)$temp[$this->parentAttribute]][$this->titleAttribute];
                $temp = $items[(int)$temp[$this->parentAttribute]];
            }

            $result[$item[$this->primaryKeyAttribute]] = implode(' - ', array_reverse($titles));
        }

        return $result;

    }

    /**
     * Returns tabulated array ($id=>$title, $id=>$title, ...)
     * @param mixed $parent number, object or array of numbers
     * @return array
     */
    public function getTabList($parent=0)
    {
        $parents = $this->processParents($parent);

        $items = $this->getFullAssocData(array(
            $this->primaryKeyAttribute,
            $this->titleAttribute,
            $this->parentAttribute
        ), $parent);

        $result = array();
        foreach ($parents as $parent_id){
            $this->_getTabListRecursive($items, $result, $parent_id);
        }

        return $result;
    }

    protected function _getTabListRecursive(&$items, &$result, $parent_id, $indent=0)
    {
        foreach ($items as $item){
            if ((int)$item[$this->parentAttribute] == (int)$parent_id && !isset($result[$item[$this->primaryKeyAttribute]])){
                $result[$item[$this->primaryKeyAttribute]] = str_repeat('-- ', $indent) . $item[$this->titleAttribute];
                $this->_getTabListRecursive($items, $result, $item[$this->primaryKeyAttribute], $indent + 1);
            }
        }
    }

    public function getTreeUrlList($parent=0)
    {
        $criteria = $this->getDefaultCriteria();

        if (!$parent)
            $parent = $this->owner->getPrimaryKey();

        if ($parent)
            $criteria->where([$this->primaryKeyAttribute => $this->getChildsArray($parent)]);

        $items = $criteria->all();

        $categories = array();
        foreach ($items as $item){
            $categories[(int)$item->{$this->parentAttribute}][] = $item;
        }

        return $this->_getUrlListRecursive ($categories, $parent);
    }

    protected function _getUrlListRecursive($items, $parent, $indent=0)
    {
        $parent = (int)$parent;
        $resultArray = array();
        if (isset($items[$parent]) && $items[$parent]){
            foreach ($items[$parent] as $item){
                $resultArray = $resultArray + array($item->{$this->urlAttribute}=>str_repeat('-- ', $indent) . $item->{$this->titleAttribute}) + $this->_getUrlListRecursive($items, $item->getPrimaryKey(), $indent + 1);
            }
        }
        return $resultArray;
    }

    public function getTreeMenuList($sub = 0, $parent = null, $htmlOptions = array())
    {
        $criteria = $this->getDefaultCriteria();

        if (!$parent)
            $parent = $this->owner->getPrimaryKey();

        if ($parent)
            $criteria->where([$this->primaryKeyAttribute=>$this->getChildsArray($parent)]);

        $items = $criteria->all();

        $categories = array();
        foreach ($items as $item) {
            $categories[(int)$item->{$this->parentAttribute}][] = $item;
        }

        return $this->_getMenuListRecursive($categories, $parent, $sub);
    }

    protected function _getMenuListRecursive($items, $parent, $sub, $htmlOptions = array())
    {
        $parent = (int)$parent;
        $resultArray = array();
        if (isset($items[$parent]) && $items[$parent]) {
            foreach ($items[$parent] as $item) {
                $resultArray[$item->getPrimaryKey()] = array(
                        'id' => $item->getPrimaryKey(),
                        'label' => $item->{$this->titleAttribute},
                        'url' => $item->{$this->urlAttribute},
                    ) + (
                    $sub ?
                        array(
                            'items' => $this->_getMenuListRecursive($items, $item->getPrimaryKey(), $sub - 1),
                            'submenuOptions'=>array('class'=>'dropdown-menu'),
                        )
                        :
                        array()
                    );
            }
        }

        return $resultArray;
    }



    /**
     * Constructs full path for current model
     * @param string $separator
     * @return string
     */
    public function getPath($separator='/')
    {

        $uri = [$this->owner->{$this->aliasAttribute}];

        $category = $this->owner;

        $i = 10;

        while ($i-- && $category->{$this->parentRelation}){
            $uri[] = $category->{$this->parentRelation}->{$this->aliasAttribute};
            $category = $category->{$this->parentRelation};
        }
        return implode(array_reverse($uri), $separator);
    }

    protected function getDefaultCriteria()
    {
        $model = $this->owner;
        return isset($this->defaultCriteria) ? $this->defaultCriteria : $model::find();
    }

    protected function processParents($parent)
    {
        if (!$parent)
            $parent = $this->owner->getPrimaryKey();
        $parents = $this->arrayFromArgs($parent);
        return $parents;
    }

    protected function arrayFromArgs($items)
    {
        $array = array();

        if (!$items){
            $items = array(0);
        } elseif (!is_array($items)){
            $items = array($items);
        }

        foreach ($items as $item) {
            if (is_object($item)) {
                $array[] = $item->getPrimaryKey();
            } else {
                $array[] = $item;
            }
        }

        return array_unique($array);
    }

    protected function getFullAssocData($attributes, $parent=0)
    {
        $criteria = $this->getDefaultCriteria();

        $attributes = array_unique(array_merge($attributes, array($this->primaryKeyAttribute)));
        $criteria->select(implode(', ', $attributes));

        if (!$parent)
            $parent = $this->owner->getPrimaryKey();

        if ($parent)
            $criteria->where([$this->primaryKeyAttribute =>  array_merge([$parent], $this->getChildsArray($parent))]);

        return $criteria->all();
    }

    protected function aliasAttributes($attributes)
    {
        $aliasesAttributes = array();
        $model = $this->owner;
        foreach ($attributes as $attribute) {
            $aliasesAttributes[] = $model::tableName() . '.' . $attribute;
        }
        return $aliasesAttributes;
    }


}