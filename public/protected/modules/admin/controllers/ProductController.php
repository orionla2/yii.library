<?php

class ProductController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='/layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view','create','update','admin','ajaxImg','ajaxDelImg'),
				'roles'=>array(2),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('delete'),
				'roles'=>array(3),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $model = new stdClass();
        //$model->product = $this->loadModel($id);
        //$model->book = Book::model()->findAllByAttributes(array('id' => $model->product->item_id));
        $sql = ProductSelect::model()->findAllByAttributes(array('p_id' => $id));
        $model = $sql[0];
        $dataProvider=new CActiveDataProvider('ProductSelect',array('criteria' => array(
            'select' => '*',
            'condition' => 'p_id = :id',
            'params' => array(':id' => $id)
        )));
        $this->render('view',array(
            'model'=>$model,
            'dataProvider'=>$dataProvider,
        ));
        
    }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate() {
		$model = new stdClass();
        $model->product = new Product;
        $model->book = new Book;
        $model->author = new Author;
        $model->category = new Category;
        $model->publisher = new Publisher;
        $model->picture = new Picture;
        
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(!empty(Yii::app()->request->getPost('productForm'))){
            $form = Yii::app()->request->getPost('productForm');
			$model->book->attributes = $form;
			$model->product->price = Money::getCoins($form['price']);
            $model->book->description = $form['description'];
            $model->book->timestamp = time();
            $validBook = $model->book->validate();
            $validProduct = $model->product->validate();
            $validCategory = $model->category->validate();
            $validAuthor = $model->author->validate();
            if($validBook && $validProduct && !empty($form['author']) && !empty($form['category'])){
                try {
                    $transaction = $model->book->dbConnection->beginTransaction();
                    $model->book->save();
                    $bookId = Yii::app()->db->getLastInsertID();
                    //$bookId = 6;
                    $model->product->item_id = $bookId;
                    $model->product->save();
                    $prodId = Yii::app()->db->getLastInsertID();
                    //$prodId = 4;
                    $authDep = new ProductAuthor;
                    $authDep->insertDependencies($prodId, $form['author']);
                    $prodDep = new ProductCategory;
                    $prodDep->insertDependencies($prodId, $form['category']);
                    $publDep = new ProductPublisher;
                    $publDep->insertDependencies($prodId, $form['publisher']);
                    $picArr = PictureConvertor::pictureTransfer($form['pictures']);
                    $idArr = array();
                    $idArr = $model->picture->insertAllPictures($picArr);
                    $pictDep = new ProductPicture;
                    $pictDep->insertDependencies($prodId, $idArr);
                    $transaction->commit();
                    $this->redirect(array('index'));
                } catch (Exception $e) {
                    $transaction->rollback();
                    PictureConvertor::rollback($picArr);
                }
            }
		}
        $model->product->price = Money::getPrice($model->product->price,false);
		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	/**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = new stdClass();
        $model->product = Product::model()->findByPk($id);
        $model->book = Book::model()->findByPk($model->product->item_id);
        $model->author = new Author;
        $model->category = new Category;
        $model->publisher = new Publisher;
        $model->picture = new Picture;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if(!empty(Yii::app()->request->getPost('productForm'))){
            $form = Yii::app()->request->getPost('productForm');
			$model->book->attributes = $form;
			$model->product->price = Money::getCoins($form['price']);
            $model->book->description = $form['description'];
            $model->book->timestamp = time();
            $validBook = $model->book->validate();
            $validProduct = $model->product->validate();
            if($validBook && $validProduct){
                
                try {
                    $transaction = $model->book->dbConnection->beginTransaction();
                    $model->book->save();
                    $model->product->save();
                    $prodId = $model->product->id;
                    $authDep = new ProductAuthor;
                    $authDep->insertDependencies($prodId, $form['author']);
                    $prodDep = new ProductCategory;
                    $prodDep->insertDependencies($prodId, $form['category']);
                    $publDep = new ProductPublisher;
                    $publDep->insertDependencies($prodId, $form['publisher']);
                    $picArr = PictureConvertor::pictureTransfer($form['pictures']);
                    if (!empty($picArr)) {
                        $idArr = array();
                        $idArr = $model->picture->insertAllPictures($picArr);
                        $pictDep = new ProductPicture;
                        $pictDep->insertDependencies($prodId, $idArr);
                    }
                    $transaction->commit();
                    $this->redirect(array('index'));
                } catch (Exception $e) {
                    $transaction->rollback();
                    PictureConvertor::rollback($picArr);
                }
            }
        }
        $model->productAuthor = ProductAuthor::prepareSelectedList(ProductAuthor::model()->findAllByAttributes(array('prod_id' => $model->product->id)));
        $model->productCategory = ProductCategory::prepareSelectedList(ProductCategory::model()->findAllByAttributes(array('prod_id' => $model->product->id)));
        $model->productPublisher = ProductPublisher::prepareSelectedList(ProductPublisher::model()->findAllByAttributes(array('prod_id' => $model->product->id)));
        $model->productPicture = ProductPicture::prepareSelectedList(ProductPicture::model()->findAllByAttributes(array('prod_id' => $model->product->id)));
        $model->product->price = Money::getPrice($model->product->price,false);
        $this->render('update',array(
            'model'=>$model,
        ));
    }

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('ProductSelect');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $this->layout = '/layouts/column3';
        $model=new ProductSelect('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['ProductSelect'])){
            $model->attributes=$_GET['ProductSelect'];
        }
            

        $this->render('admin',array(
            'model'=>$model,
        ));
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Product the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Product::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Product $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='product-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    
    public function actionAjaxImg () {
        $uploaddir = getcwd() . '/images/temp/';
        
        $uploadfile = $uploaddir . basename($_FILES['gfiles']['name']);

        move_uploaded_file($_FILES['gfiles']['tmp_name'], $uploadfile);

        echo '/images/temp/' . $_FILES['gfiles']['name'];
        exit; 
        
        
    }
    public function actionAjaxDelImg () {
        $path = Yii::getPathOfAlias('webroot'). Yii::app()->request->getPost('filePath');
        $req = Yii::app()->request->getPost('filePath');
        if (file_exists($path)) {
            $pic = Picture::model()->findByAttributes(array('path' => $req));
            if (!empty($pic->id)) {
                $pic_id = $pic->id;
                $dep = ProductPicture::model()->findByAttributes(array('picture_id' => $pic_id));
                $dep_id = $dep->id;
                ProductPicture::model()->deleteByPk(array($dep_id));
                Picture::model()->deleteByPk(array($pic_id)); 
            }
            if(unlink($path)){
                echo "successfully deleted: $path";
            } else {
                echo "Error: $path wasn't deleted";
            }
        } else {
            $pic = Picture::model()->findByAttributes(array('path' => $req));
            if (!empty($pic->id)) {
                $pic_id = $pic->id;
                $dep = ProductPicture::model()->findByAttributes(array('picture_id' => $pic_id));
                $dep_id = $dep->id;
                ProductPicture::model()->deleteByPk(array($dep_id));
                Picture::model()->deleteByPk(array($pic_id)); 
            }
        }
        exit;
    }
}
