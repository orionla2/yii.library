<?php

class JuiMenuWidget extends CWidget
{
    /**
     * @var string имя пользователя
     */
    public $username = '';
    public $items;
    public $model;
    public $itemView = 'juiMenuView';
    public $itemsCssClass;
    public $itemsCssContainer = 'menu';
    
 
    public function init(){
        if($this->items === null){
            throw new CException(Yii::t('zii','The "picturesArr" property cannot be empty.'));
        }
        if($this->model !== null){
            $arr = $this->treeSortArr($this->items,$this->model['parent_id']);
            $retArr = $this->prepareTreeStructure($arr,$this->model['id'],$this->model['name'],$this->model['request'],($this->model['start_id']) ? $this->model['start_id'] : 1);
            $this->items = $retArr;
        }
	}
    /**
     * Запуск виджета
     */
    public function run()
    {
        $this->render($this->itemView, array(
            'items' => $this->items,
            'itemsCssContainer' => $this->itemsCssContainer,
        ));
    }
    public function renderMenu ($arr,$id=null) {
        $ret = ($id)? "<ul id=$id>" : "<ul>";
        foreach($arr as $key => $val){
            if(!isset($val['visible'])){
                $val['visible'] = true;
            }
            if($val['visible'] == true){
                $ret .= '<li>';
                $ret .= CHtml::link($val['label'], ($val['url']) ? $val['url'] : null);
                if(!empty($val['items'])){
                    $ret .= $this->renderMenu($val['items']);
                }
                $ret .= '</li>';
            }
        }
        $ret .= '</ul>';
        return $ret;
    }
    private function treeSortArr ($arr,$pid) {
        $retArr = array();
        foreach ($arr as $obj) {
            $retArr[$obj->parent_id][] = $obj;
        }
        return $retArr;
    }
    private function prepareTreeStructure ($arr,$id,$name,$request,$pid = 1) {
        if(empty($arr[$pid])){
            return;
        }
        foreach ($arr[$pid] as $k => $v) {
            $temp[] = array(
                'label' => $v->$name,
                'url' => array($request . $v->$name),
                'items' => self::prepareTreeStructure($arr,$id,$name,$request,$arr[$pid][$k]->$id)
            );
        }
        return $temp;
    }
}