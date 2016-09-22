<?php

class ProductSliderWidget extends CWidget
{
    /**
     * @var string имя пользователя
     */
    public $username = '';
    public $picturesArr;
    public $itemView;
    public $itemsCssClass;
    
 
    public function init(){
		if($this->picturesArr===null)
			throw new CException(Yii::t('zii','The "picturesArr" property cannot be empty.'));
	}
    /**
     * Запуск виджета
     */
    public function run()
    {
        $this->render($this->itemView, array(
            'pictureArr' => $this->picturesArr,
        ));
    }
}

