<?php

/**
 * This is the model class for table "product_select".
 *
 * The followings are the available columns in table 'product_select':
 * @property integer $p_id
 * @property integer $price
 * @property string $full_name
 * @property string $name
 * @property integer $year
 * @property integer $available
 * @property string $isbn
 * @property string $description
 * @property string $category
 * @property string $picture
 * @property string $publisher
 */
class ProductSelect extends CActiveRecord
{
	public $max;
	public $min;
    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product_select';
	}
    public function primaryKey(){
        return 'p_id';
    }
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Category,Authors,price, name, year, available, isbn, description, publisher', 'required'),
			array('p_id, price, year, available', 'numerical', 'integerOnly'=>true),
			array('name, isbn, publisher', 'length', 'max'=>255),
			array('full_name, picture', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('p_id, price, full_name, name, year, available, isbn, description, category, picture, publisher', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'p_id' => 'id',
			'price' => 'Price',
			'full_name' => 'Authors',
			'name' => 'Title',
			'year' => 'Year',
			'available' => 'Available',
			'isbn' => 'Isbn',
			'description' => 'Description',
			'category' => 'Category',
			'picture' => 'Picture',
			'publisher' => 'Publisher',
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
        $criteria=new ExtendedFilters();
		$criteria->compare('p_id',$this->p_id);
		$criteria->compare('price',$this->price);
		$criteria->compare('full_name',$this->full_name,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('year',$this->year);
		$criteria->compare('available',$this->available);
		$criteria->compare('isbn',$this->isbn,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('category',$this->category,true);
		$criteria->compare('picture',$this->picture,true);
		$criteria->compare('publisher',$this->publisher,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductSelect the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    public static function getMinMaxPriceFromCategory($id){
        $criteria = new CDbCriteria();
        $criteria->select = 'max(`price`) as max, min(`price`) as min';
        $criteria->condition = 'available = 1 and category LIKE :text';
        $criteria->params = array(':text' => "%$id%");
        $models = self::model()->findAll($criteria);
        $array = array((int)$models[0]->min,(int)$models[0]->max);
        return $array;
    }
    public static function getNewUpdates ($n) {
        $arr = self::model()->findAll(array(
            'condition' => 'available = :mark',
            'params' => array(':mark' => 1),
            'order' => 'p_id DESC',
            'limit' => "$n"
        ));
        return $arr;
    }
}
