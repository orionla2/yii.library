<?php

/**
 * This is the model class for table "publisher".
 *
 * The followings are the available columns in table 'publisher':
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property string $phone
 * @property string $description
 *
 * The followings are the available model relations:
 * @property ProductPublisher[] $productPublishers
 */
class Publisher extends CActiveRecord
{
    public function primaryKey() {
        return 'id';
    }
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'publisher';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, address, phone', 'required'),
			array('name, address, phone', 'length', 'max'=>255),
			array('description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, address, phone, description', 'safe', 'on'=>'search'),
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
			'productPublishers' => array(self::HAS_MANY, 'ProductPublisher', 'publisher_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Publisher',
			'address' => 'Address',
			'phone' => 'Phone',
			'description' => 'Description',
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
		$criteria->compare('address',$this->address,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Publisher the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public static function all() {
        $models = self::model()->findAll();
        $array = CHtml::listData($models,'id','name');
        return $array;
    }
    public static function getAllPicturesByPublisher () {
        $model = PublisherPicture::model()->findAll();
        return $model;
    }
    public static function getPublisherIdByName($fullname){
        $models = self::model()->findAllbySql("SELECT `id` FROM `publisher` WHERE  `name` LIKE '$fullname'");
        $retArr = array('id' => $models[0]->id, 'fullname' => $fullname);
        return $retArr;
    }
}
