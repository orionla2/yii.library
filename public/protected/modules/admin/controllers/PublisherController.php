<?php

class PublisherController extends Controller
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
		$model = Publisher::model()->findByPk($id);
        $dataProvider=new CActiveDataProvider('Publisher',array('criteria' => array(
            'select' => '*',
            'condition' => 'id = :id',
            'params' => array(':id' => $id)
        )));
        $this->render('view',array(
			'model'=>$model,
            'dataProvider' => $dataProvider
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate(){
        $model = new stdClass();
        $model->publisher = new Publisher;
        $model->picture = new Picture;
        
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(!empty(Yii::app()->request->getPost('publisherForm'))){
            $form = Yii::app()->request->getPost('publisherForm');
            $model->itemPicture = $form['pictures'];
            $model->publisher->attributes = $form;
            if($model->publisher->validate()){
                try {
                    $transaction = $model->publisher->dbConnection->beginTransaction();
                    $model->publisher->save();
                    $publisherId = Yii::app()->db->getLastInsertID();
                    //$authorId = 6;
                    $picArr = PictureConvertor::pictureTransfer($form['pictures']);
                    $model->itemPicture = json_encode($picArr);
                    $idArr = array();
                    $idArr = $model->picture->insertAllPictures($picArr);
                    $itemPic = new ItemPicture;
                    $itemPic->insertDependencies($publisherId, $idArr, $model->publisher->tableName());
                    $transaction->commit();
                    //$transaction->rollback();
                    $this->redirect(array('view','id'=>$publisherId));
                } catch (Exception $e) {
                    $transaction->rollback();
                    PictureConvertor::rollback($picArr);
                }
            }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = new stdClass();
        $model->publisher = Publisher::model()->findByPk($id);
        $model->picture = new Picture;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(!empty(Yii::app()->request->getPost('publisherForm'))){
            $form = Yii::app()->request->getPost('publisherForm');
            $model->itemPicture = $form['pictures'];
            $model->publisher->attributes = $form;
            if($model->publisher->validate()){
                try {
                    $transaction = $model->publisher->dbConnection->beginTransaction();
                    $model->publisher->save();
                    $publisherId = $model->publisher->id;
                    //$authorId = 6;
                    $picArr = PictureConvertor::pictureTransfer($form['pictures']);
                    $model->itemPicture = json_encode($picArr);
                    $idArr = array();
                    $idArr = $model->picture->insertAllPictures($picArr);
                    $itemPic = new ItemPicture;
                    $itemPic->insertDependencies($publisherId, $idArr, $model->publisher->tableName());
                    $transaction->commit();
                    $this->redirect(array('view','id'=>$publisherId));
                } catch (Exception $e) {
                    $transaction->rollback();
                    PictureConvertor::rollback($picArr);
                }
            }
			//if($model->save())
				//$this->redirect(array('view','id'=>$model->id));
		}
        $model->itemPicture = ItemPicture::prepareSelectedList(ItemPicture::model()->findAllByAttributes(
                array(
                    'item_id' => $model->publisher->id,
                    'table' => $model->publisher->tableName()
                )));
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
		$this->layout = '/layouts/column2';
        $dataProvider=new CActiveDataProvider('Publisher');
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
        $model=new Publisher('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Publisher']))
			$model->attributes=$_GET['Publisher'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Publisher the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Publisher::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Publisher $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='publisher-form')
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
                $dep = itemPicture::model()->findByAttributes(array('picture_id' => $pic_id));
                $dep_id = $dep->id;
                itemPicture::model()->deleteByPk(array($dep_id));
                Picture::model()->deleteByPk(array($pic_id));
            }
            if(unlink($path)){
                echo "successfully deleted: $path";
            } else {
                echo "Error: $path wasn't deleted";
            }
        } else {
            echo "Error: $path file not exists";
        }
        exit;
    }
}
