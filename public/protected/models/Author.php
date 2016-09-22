<?php

/**
 * This is the model class for table "author".
 *
 * The followings are the available columns in table 'author':
 * @property integer $id
 * @property string $name
 * @property string $surname
 * @property string $description
 *
 * The followings are the available model relations:
 * @property ProductAuthor[] $productAuthors
 */

class Author extends CActiveRecord
{
    public function primaryKey() {
        return 'id';
    }
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'author';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, surname, description', 'required'),
			array('name, surname', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, surname, description', 'safe', 'on'=>'search'),
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
			'productAuthors' => array(self::HAS_MANY, 'ProductAuthor', 'author_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Author',
			'surname' => 'Surname',
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
		$criteria->compare('surname',$this->surname,true);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Author the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public static function all() {
        $models = self::model()->findAllbySql('SELECT `id`,CONCAT(`name`," ",`surname`) as `name` FROM `author` ORDER BY `name` ASC');
        $array = CHtml::listData($models,'id','name');
        return $array;
    }
    public static function getAllPicturesByAuthor () {
        $model = AuthorPicture::model()->findAll();
        
        return $model;
    }
    public static function getAuthorIdByFullname($fullname){
        $nameArr = explode(' ',$fullname);
        $cnt = count($nameArr) - 1;
        $models = self::model()->findAllbySql("SELECT `id` FROM `author` WHERE `name` LIKE '%$nameArr[0]%' and `surname` LIKE '$nameArr[$cnt]'");
        $retArr = array('id' => $models[0]->id, 'fullname' => $fullname);
        return $retArr;
    }
}
