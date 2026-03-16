<?php
/* @var $this ChatAdminController */
/* @var $model ChatAnswer */
/* @var $categories ChatCategory[] */
/* @var $phrases ChatPhrase[] */

$this->breadcrumbs=array(
	'Чат-бот' => array('index'),
	'Ответы' => array('answerIndex'),
	$model->title => array('answerView', 'id'=>$model->id),
	'Редактировать',
);

$this->menu=array(
	array('label'=>'Создать ответ', 'url'=>array('answerCreate')),
	array('label'=>'Управление категориями', 'url'=>array('categoryIndex')),
	array('label'=>'Управление ответами', 'url'=>array('answerIndex')),
	array('label'=>'Просмотр', 'url'=>array('answerView', 'id'=>$model->id)),
	array('label'=>'Статистика', 'url'=>array('stats')),
);
?>

<h1>Редактировать ответ #<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'categories'=>$categories, 'phrases'=>$phrases)); ?>

