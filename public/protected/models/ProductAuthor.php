<?php

/**
 * This is the model class for table "product_author".
 *
 * The followings are the available columns in table 'product_author':
 * @property integer $id
 * @property integer $prod_id
 * @property integer $author_id
 *
 * The followings are the available model relations:
 * @property Product $prod
 * @property Author $author
 */
class ProductAuthor extends CActiveRecord
{
    public function primaryKey() {
        return 'id';
    }
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product_author';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('prod_id, author_id', 'required'),
			array('prod_id, author_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, prod_id, author_id', 'safe', 'on'=>'search'),
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
			'prod' => array(self::BELONGS_TO, 'Product', 'prod_id'),
			'author' => array(self::BELONGS_TO, 'Author', 'author_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'prod_id' => 'Prod',
			'author_id' => 'Author',
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
		$criteria->compare('prod_id',$this->prod_id);
		$criteria->compare('author_id',$this->author_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductAuthor the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    public function insertDependencies ($prod_id, $itemsArr) {
        $builder=Yii::app()->db->schema->commandBuilder;
        foreach ($itemsArr as $item) {
            $retArr[] = array(
                'prod_id' => $prod_id,
                'author_id' => $item
            );
        }
        ProductAuthor::model()->deleteAll('prod_id = :id',array(':id' => $prod_id));
        $command = $builder->createMultipleInsertCommand('product_author', $retArr);
        $command->execute();
    }
    public static function prepareSelectedList ($list) {
        foreach ($list as $item) {
            $retArr[$item->author_id] = Array ( 'selected' => 'selected' );
        }
        return $retArr;
    }
}
