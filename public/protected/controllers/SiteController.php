<?php

class SiteController extends Controller
{
	//public $layout='/layouts/column2';
    /**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$this->layout = '/layouts/column2';
        $model=new ProductSelect('search');
        $model->unsetAttributes();  // clear any default values
        $model->available = 1;
        if(!empty(Yii::app()->getRequest()->getQuery('ProductSelect'))){
            $model->attributes = Yii::app()->getRequest()->getQuery('ProductSelect');
        }
        $this->render('index',array(
            'model'=>$model,
        ));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(!empty(Yii::app()->getRequest()->getPost('ContactForm'))){
			$model->attributes = Yii::app()->getRequest()->getPost('ContactForm');
			if($model->validate()){
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$this->layout = '/layouts/column1';
        $model=new LoginForm;

		// if it is ajax validation request
		if(!empty(Yii::app()->getRequest()->getPost('ajax')) && Yii::app()->getRequest()->getPost('ajax')==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(!empty(Yii::app()->getRequest()->getPost('LoginForm')))
		{
			$model->attributes = Yii::app()->getRequest()->getPost('LoginForm');
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
    public function actionAbout () {
        $this->render('about');
    }
    public function actionCategory ($name) {
        $this->layout = '/layouts/column2';
        $model=new ProductSelect('search');
        $model->unsetAttributes();  // clear any default values
        $model->category = $name;
        $model->available = 1;
        if(!empty(Yii::app()->getRequest()->getQuery('ProductSelect'))){
            $model->attributes = Yii::app()->getRequest()->getQuery('ProductSelect');
        }
        
        $this->render('category',array(
            'model' => $model
        ));
    }
    public function actionAdmin () {
        $this->layout = '/layouts/column2';
        $model=new ProductSelect('search');
        //var_dump($model);
        $model->unsetAttributes();  // clear any default values
        
        if(!empty(Yii::app()->getRequest()->getQuery('ProductSelect')))
            $model->attributes = Yii::app()->getRequest()->getQuery('ProductSelect');

        $this->render('admin',array(
            'model'=>$model,
        ));
    }
    public function actionView ($id) {
        $this->layout = '/layouts/column3';
        $model=new ProductSelect('search');
        $model->unsetAttributes();  // clear any default values
        $model->p_id = $id;
        //var_dump($model->attributes);
        $dataProvider=new CActiveDataProvider('ProductSelect',array('criteria' => array(
            'select' => '*',
            'condition' => 'p_id = :id',
            'params' => array(':id' => $id)
        )));
        if(!empty(Yii::app()->getRequest()->getQuery('ProductSelect'))){
            $model->attributes = Yii::app()->getRequest()->getQuery('ProductSelect');
        }
        
        $this->render('view',array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'id' => $id,
        ));
    }
    public function actionRegistration () {
        $this->layout = '/layouts/column1';
        $model = new User;
        $model->scenario = 'registration';
        
        
        if (!empty(Yii::app()->getRequest()->getPost('User'))) {
            $model->attributes = Yii::app()->getRequest()->getPost('User');
            $settings = Settings::model()->findByPk(1);
            if ($settings->defaultStatusUser == 0) {
                $model->ban = 0;
            } else {
                $model->ban = 1;
            }
            if ($model->save()) {
                if ($settings->defaultStatusUser == 0) {
                    Yii::app()->user->setFlash('registration','Thank you for registration. You can login.');
                } else {
                    Yii::app()->user->setFlash('registration','Please wait when admin will confirm your registration.');
                }
                //$this->redirect(array('index'));
                
				//$this->refresh();
            }
        }
        
        $this->render('registration',array(
            'model' => $model
        ));
    }
    public function actionAjaxRequest () {
        $id = Yii::app()->getRequest()->getPost('id');
        $controller = Yii::app()->getRequest()->getPost('controller');
        $dataProvider=new CActiveDataProvider($controller,array('criteria' => array(
            'select' => '*',
            'condition' => 'id = :id',
            'params' => array(':id' => $id)
        )));
        $method = 'getAllPicturesBy' .$controller;
        $viewFile = '_view' .$controller;
        $this->widget('ext.customWidgets.ItemViewWidget', array(
        'dataProvider'=>$dataProvider,
        'pictures'=>$controller::model()->$method(),
        'itemView' => $viewFile,
        'enablePagination' => false,
        'summaryText' => '',
        'itemsCssClass' => 'templatemo_content_right'
        ));
    }
}