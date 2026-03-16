<?php
/* @var $this ChatAdminController */
/* @var $model ChatCategory */

$this->breadcrumbs=array(
	'Чат-бот' => array('index'),
	'Категории' => array('categoryIndex'),
	'Создать',
);

$this->menu=array(
	array('label'=>'Создать категорию', 'url'=>array('categoryCreate'), 'active'=>true),
	array('label'=>'Управление категориями', 'url'=>array('categoryIndex')),
	array('label'=>'Управление ответами', 'url'=>array('answerIndex')),
	array('label'=>'Статистика', 'url'=>array('stats')),
);
?>

<h1>Создать категорию</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

