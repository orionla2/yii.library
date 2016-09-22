<?php

/**
 * This is the model class for table "item_picture".
 *
 * The followings are the available columns in table 'item_picture':
 * @property integer $id
 * @property string $table
 * @property integer $item_id
 * @property integer $picture_id
 *
 * The followings are the available model relations:
 * @property Category $item
 * @property Picture $picture
 */
class ItemPicture extends CActiveRecord
{
    public function primaryKey() {
        return 'id';
    }
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'item_picture';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('table, item_id, picture_id', 'required'),
			array('item_id, picture_id', 'numerical', 'integerOnly'=>true),
			array('table', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, table, item_id, picture_id', 'safe', 'on'=>'search'),
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
			//'item' => array(self::BELONGS_TO, 'Category', 'item_id'),
			//'item' => array(self::BELONGS_TO, 'Author', 'item_id'),
			//'item' => array(self::BELONGS_TO, 'Publisher', 'item_id'),
			'picture' => array(self::BELONGS_TO, 'Picture', 'picture_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'table' => 'Table',
			'item_id' => 'Item',
			'picture_id' => 'Picture',
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
		$criteria->compare('table',$this->table,true);
		$criteria->compare('item_id',$this->item_id);
		$criteria->compare('picture_id',$this->picture_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ItemPicture the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    public function insertDependencies ($item_id, $itemsArr, $table) {
        $builder=Yii::app()->db->schema->commandBuilder;
        foreach ($itemsArr as $item) {
            $retArr[] = array(
                'table' => $table,
                'item_id' => (int)$item_id,
                'picture_id' => (int)$item
            );
        }
        //ProductPicture::model()->deleteAll('prod_id = :id',array(':id' => $prod_id));
        if (!empty($retArr)) {
            $command = $builder->createMultipleInsertCommand('item_picture', $retArr);
            $command->execute(); 
        }
    }
    public function deleteDependencies ($prod_id, $itemsArr) {
        $builder=Yii::app()->db->schema->commandBuilder;
        foreach ($itemsArr as $item) {
            $retArr[] = array(
                'prod_id' => $prod_id,
                'picture_id' => $item
            );
        }
        ProductPicture::model()->deleteAll('prod_id = :id',array(':id' => $prod_id));
        $command = $builder->createMultipleInsertCommand('product_picture', $retArr);
        $command->execute();
    }
    public static function prepareSelectedList ($list) {
        $retArr = array();
        foreach ($list as $item) {
            $pic = Picture::model()->findByPk($item->picture_id);
            $retArr[$pic->path] = $pic->path;
        }
        if (!empty($retArr)) {
            return json_encode($retArr);
        } else {
            return '{}';
        }
        
    }
}
