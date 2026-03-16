<?php
/* @var $this ChatAdminController */
/* @var $model ChatCategory */

$this->breadcrumbs=array(
	'Чат-бот' => array('index'),
	'Категории' => array('categoryIndex'),
	$model->title => array('categoryView', 'id'=>$model->id),
	'Редактировать',
);

$this->menu=array(
	array('label'=>'Создать категорию', 'url'=>array('categoryCreate')),
	array('label'=>'Управление категориями', 'url'=>array('categoryIndex')),
	array('label'=>'Просмотр', 'url'=>array('categoryView', 'id'=>$model->id)),
	array('label'=>'Управление ответами', 'url'=>array('answerIndex')),
	array('label'=>'Статистика', 'url'=>array('stats')),
);
?>

<h1>Редактировать категорию #<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

