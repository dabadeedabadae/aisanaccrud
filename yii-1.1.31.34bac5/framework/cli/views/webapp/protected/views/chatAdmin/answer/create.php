<?php
/* @var $this ChatAdminController */
/* @var $model ChatAnswer */
/* @var $categories ChatCategory[] */

$this->breadcrumbs=array(
	'Чат-бот' => array('index'),
	'Ответы' => array('answerIndex'),
	'Создать',
);

$this->menu=array(
	array('label'=>'Создать ответ', 'url'=>array('answerCreate'), 'active'=>true),
	array('label'=>'Управление категориями', 'url'=>array('categoryIndex')),
	array('label'=>'Управление ответами', 'url'=>array('answerIndex')),
	array('label'=>'Статистика', 'url'=>array('stats')),
);
?>

<h1>Создать ответ</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'categories'=>$categories)); ?>

