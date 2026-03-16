<?php

class AisanaController extends Controller
{
	public function actionIndex()
	{
		$this->layout = 'main';
		$this->render('index');
	}

	public function actionNews()
	{
		$this->layout = 'main';
		
		$news = News::model()->findAll(array(
			'condition' => 'published = 1',
			'order' => 'created_at DESC',
		));
		
		$this->render('news', array('news' => $news));
	}

	public function actionNewsView($slug)
	{
		$this->layout = 'main';
		
		$news = News::model()->find('slug = :slug AND published = 1', array(':slug' => $slug));
		
		if($news === null)
			throw new CHttpException(404, Yii::t('labels', 'Новость не найдена'));
		
		$this->render('newsView', array('news' => $news));
	}

	public function actionCourses()
	{
		$this->layout = 'main';
		
		$courses = Course::model()->findAll(array(
			'condition' => 'published = 1',
			'order' => 'created_at DESC',
		));
		
		$this->render('courses', array('courses' => $courses));
	}

	public function actionProjects()
	{
		$this->layout = 'main';
		
		$projects = Project::model()->findAll(array(
			'condition' => 'published = 1',
			'order' => 'created_at DESC',
		));
		
		$this->render('projects', array('projects' => $projects));
	}

	public function actionProjectView($id)
	{
		$this->layout = 'main';
		
		$project = Project::model()->findByPk($id);
		
		if($project === null || !$project->published)
			throw new CHttpException(404, Yii::t('labels', 'Проект не найден'));
		
		$this->render('projectView', array('project' => $project));
	}
}
