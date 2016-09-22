<?php

/**
 * This is the model class for table "category".
 *
 * The followings are the available columns in table 'category':
 * @property integer $id
 * @property string $name
 * @property integer $parent_id
 *
 * The followings are the available model relations:
 * @property ProductCategory[] $productCategories
 */
class Category extends CActiveRecord
{
    public function primaryKey() {
        return 'id';
    }
	public static $tree = array();
    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, parent_id', 'required'),
			array('parent_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, parent_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'productCategories' => array(self::HAS_MANY, 'ProductCategory', 'category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Category',
			'parent_id' => 'Parent',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('parent_id',$this->parent_id);
        

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Category the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public static function getAvailParents() {
        //$models = self::model()->findAllByAttributes(array('parent_id' => 1));
        $models = self::model()->findAllByAttributes(array('parent_id' => 1),'name <> :name',array(':name' => 'none'));
        $array = CHtml::listData($models,'id','name');
        return $array;
    }
    
    public static function all() {
        $models = self::model()->findAll();
        $array = CHtml::listData($models,'id','name');
        return $array;
    }
    public static function getTreeStructure () {
        $models = self::model()->findAll();
        $sortedArr = self::treeSortArr($models);
        $retArr = self::prepareTreeStructure($sortedArr);
        return $retArr;
        
    }
    private static function treeSortArr ($arr) {
        //xdebug_break();
        $retArr = array();
        foreach ($arr as $obj) {
            $retArr[$obj->parent_id][] = $obj;
        }
        return $retArr;
    }
    private static function prepareTreeStructure ($arr,$pid = 1) {
        //xdebug_break();
        if(empty($arr[$pid])){
            return;
        }
        //$retArr = array();
        foreach ($arr[$pid] as $k => $v) {
            $temp[] = array(
                'text' => CHtml::link($v->name, array('view', 'id'=>$v->id)),
                'expanded' => true,
                'children' => self::prepareTreeStructure($arr,$arr[$pid][$k]->id)
            );
        }
        return $temp;
        //return $retArr;
    }
}
