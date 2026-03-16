<?php
class AdminController extends Controller
{
	public $defaultAction = 'login';
	public function actions()
	{
		return array(
		);
	}
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
	public function actionLogin()
	{
		if(!Yii::app()->user->isGuest)
		{
			$this->redirect(array('admin/dashboard'));
		}
		$model = new LoginForm;
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if(isset($_POST['LoginForm']))
		{
			$model->attributes = $_POST['LoginForm'];
			if($model->validate() && $model->login())
			{
				$this->redirect(array('admin/dashboard'));
			}
		}
		$this->render('login', array('model' => $model));
	}
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(array('admin/login'));
	}
	public function actionDashboard()
	{
		if(Yii::app()->user->isGuest)
		{
			$this->redirect(array('admin/login'));
		}
		$stats = array(
			'totalUsers' => User::model()->count(),
			'totalNews' => News::model()->count(),
			'totalCourses' => Course::model()->count(),
			'totalProjects' => Project::model()->count(),
		);
		$this->render('dashboard', array('stats' => $stats));
	}
	public function actionNewsIndex()
	{
		if(Yii::app()->user->isGuest)
		{
			$this->redirect(array('admin/login'));
		}
		$model = new News('search');
		$model->unsetAttributes();
		if(isset($_GET['News']))
			$model->attributes = $_GET['News'];
		$this->render('news/index', array('model' => $model));
	}
	public function actionNewsCreate()
	{
		if(Yii::app()->user->isGuest)
		{
			$this->redirect(array('admin/login'));
		}
		$model = new News;
		if(isset($_POST['News']))
		{
			$model->attributes = $_POST['News'];
			$model->imageFile = CUploadedFile::getInstance($model, 'imageFile');
			if($model->save())
			{
				Yii::app()->user->setFlash('success', Yii::t('labels', 'Новость успешно создана'));
				$this->redirect(array('admin/newsIndex'));
			}
		}
		$this->render('news/create', array('model' => $model));
	}
	public function actionNewsUpdate($id)
	{
		if(Yii::app()->user->isGuest)
		{
			$this->redirect(array('admin/login'));
		}
		$model = News::model()->findByPk($id);
		if($model === null)
			throw new CHttpException(404, Yii::t('labels', 'Новость не найдена'));
		if(isset($_POST['News']))
		{
			$oldImage = $model->image;
			$model->attributes = $_POST['News'];
			$model->imageFile = CUploadedFile::getInstance($model, 'imageFile');
			if($model->imageFile === null && empty($model->image))
			{
				$model->image = $oldImage;
			}
			if($model->save())
			{
				Yii::app()->user->setFlash('success', Yii::t('labels', 'Новость успешно обновлена'));
				$this->redirect(array('admin/newsIndex'));
			}
		}
		$this->render('news/update', array('model' => $model));
	}
	public function actionNewsDelete($id)
	{
		if(Yii::app()->user->isGuest)
		{
			$this->redirect(array('admin/login'));
		}
		if(Yii::app()->request->isPostRequest)
		{
			$model = News::model()->findByPk($id);
			if($model !== null)
			{
				$model->delete();
				Yii::app()->user->setFlash('success', Yii::t('labels', 'Новость успешно удалена'));
			}
			if(!isset($_GET['ajax']))
				$this->redirect(array('admin/newsIndex'));
		}
		else
			throw new CHttpException(400, Yii::t('labels', 'Неверный запрос'));
	}
	public function actionNewsView($id)
	{
		if(Yii::app()->user->isGuest)
		{
			$this->redirect(array('admin/login'));
		}
		$model = News::model()->findByPk($id);
		if($model === null)
			throw new CHttpException(404, Yii::t('labels', 'Новость не найдена'));
		$this->render('news/view', array('model' => $model));
	}
	public function actionCoursesIndex()
	{
		if(Yii::app()->user->isGuest)
		{
			$this->redirect(array('admin/login'));
		}
		$model = new Course('search');
		$model->unsetAttributes();
		if(isset($_GET['Course']))
			$model->attributes = $_GET['Course'];
		$this->render('courses/index', array('model' => $model));
	}
	public function actionCoursesCreate()
	{
		if(Yii::app()->user->isGuest)
		{
			$this->redirect(array('admin/login'));
		}
		$model = new Course;
		if(isset($_POST['Course']))
		{
			$model->attributes = $_POST['Course'];
			if($model->save())
			{
				Yii::app()->user->setFlash('success', Yii::t('labels', 'Курс успешно создан'));
				$this->redirect(array('admin/coursesIndex'));
			}
		}
		$this->render('courses/create', array('model' => $model));
	}
	public function actionCoursesUpdate($id)
	{
		if(Yii::app()->user->isGuest)
		{
			$this->redirect(array('admin/login'));
		}
		$model = Course::model()->findByPk($id);
		if($model === null)
			throw new CHttpException(404, Yii::t('labels', 'Курс не найден'));
		if(isset($_POST['Course']))
		{
			$model->attributes = $_POST['Course'];
			if($model->save())
			{
				Yii::app()->user->setFlash('success', Yii::t('labels', 'Курс успешно обновлен'));
				$this->redirect(array('admin/coursesIndex'));
			}
		}
		$this->render('courses/update', array('model' => $model));
	}
	public function actionCoursesDelete($id)
	{
		if(Yii::app()->user->isGuest)
		{
			$this->redirect(array('admin/login'));
		}
		if(Yii::app()->request->isPostRequest)
		{
			$model = Course::model()->findByPk($id);
			if($model !== null)
			{
				$model->delete();
				Yii::app()->user->setFlash('success', Yii::t('labels', 'Курс успешно удален'));
			}
			if(!isset($_GET['ajax']))
				$this->redirect(array('admin/coursesIndex'));
		}
		else
			throw new CHttpException(400, Yii::t('labels', 'Неверный запрос'));
	}
	public function actionCoursesView($id)
	{
		if(Yii::app()->user->isGuest)
		{
			$this->redirect(array('admin/login'));
		}
		$model = Course::model()->findByPk($id);
		if($model === null)
			throw new CHttpException(404, Yii::t('labels', 'Курс не найден'));
		$this->render('courses/view', array('model' => $model));
	}
	
	public function actionProjectsIndex()
	{
		if(Yii::app()->user->isGuest)
		{
			$this->redirect(array('admin/login'));
		}
		$model = new Project('search');
		$model->unsetAttributes();
		if(isset($_GET['Project']))
			$model->attributes = $_GET['Project'];
		$this->render('projects/index', array('model' => $model));
	}
	
	public function actionProjectsCreate()
	{
		if(Yii::app()->user->isGuest)
		{
			$this->redirect(array('admin/login'));
		}
		$model = new Project;
		if(isset($_POST['Project']))
		{
			$model->attributes = $_POST['Project'];
			$model->logoFile = CUploadedFile::getInstance($model, 'logoFile');
			if($model->save())
			{
				Yii::app()->user->setFlash('success', Yii::t('labels', 'Проект успешно создан'));
				$this->redirect(array('admin/projectsIndex'));
			}
		}
		$this->render('projects/create', array('model' => $model));
	}
	
	public function actionProjectsUpdate($id)
	{
		if(Yii::app()->user->isGuest)
		{
			$this->redirect(array('admin/login'));
		}
		$model = Project::model()->findByPk($id);
		if($model === null)
			throw new CHttpException(404, Yii::t('labels', 'Проект не найден'));
		
		$oldLogo = $model->logo;
		$oldScreenshots = $model->screenshots;
		
		if(isset($_POST['Project']))
		{
			$model->attributes = $_POST['Project'];
			$model->logoFile = CUploadedFile::getInstance($model, 'logoFile');
			
			if($model->logoFile === null && empty($model->logo) && !empty($oldLogo))
			{
				$model->logo = $oldLogo;
			}
			
			if($model->save())
			{
				Yii::app()->user->setFlash('success', Yii::t('labels', 'Проект успешно обновлен'));
				$this->redirect(array('admin/projectsIndex'));
			}
		}
		$this->render('projects/update', array('model' => $model));
	}
	
	public function actionProjectsDelete($id)
	{
		if(Yii::app()->user->isGuest)
		{
			$this->redirect(array('admin/login'));
		}
		if(Yii::app()->request->isPostRequest)
		{
			$model = Project::model()->findByPk($id);
			if($model !== null)
			{
				$model->delete();
				Yii::app()->user->setFlash('success', Yii::t('labels', 'Проект успешно удален'));
			}
			if(!isset($_GET['ajax']))
				$this->redirect(array('admin/projectsIndex'));
		}
		else
			throw new CHttpException(400, Yii::t('labels', 'Неверный запрос'));
	}
	
	public function actionProjectsView($id)
	{
		if(Yii::app()->user->isGuest)
		{
			$this->redirect(array('admin/login'));
		}
		$model = Project::model()->findByPk($id);
		if($model === null)
			throw new CHttpException(404, Yii::t('labels', 'Проект не найден'));
		$this->render('projects/view', array('model' => $model));
	}
	
	public function actionProjectsDeleteScreenshot($id, $index)
	{
		if(Yii::app()->user->isGuest)
		{
			$this->redirect(array('admin/login'));
		}
		if(Yii::app()->request->isPostRequest)
		{
			$model = Project::model()->findByPk($id);
			if($model !== null)
			{
				if($model->deleteScreenshot($index))
				{
					Yii::app()->user->setFlash('success', Yii::t('labels', 'Скриншот успешно удален'));
				}
			}
			if(!isset($_GET['ajax']))
				$this->redirect(array('admin/projectsUpdate', 'id' => $id));
		}
		else
			throw new CHttpException(400, Yii::t('labels', 'Неверный запрос'));
	}
}