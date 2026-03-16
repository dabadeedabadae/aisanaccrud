<?php
/* @var $this ChatAdminController */
/* @var $model ChatCategory */

$this->breadcrumbs=array(
	'Чат-бот' => array('index'),
	'Категории',
);

$this->menu=array(
	array('label'=>'Создать категорию', 'url'=>array('categoryCreate')),
	array('label'=>'Управление категориями', 'url'=>array('categoryIndex'), 'active'=>true),
	array('label'=>'Управление ответами', 'url'=>array('answerIndex')),
	array('label'=>'Статистика', 'url'=>array('stats')),
);
?>

<h1>Управление категориями</h1>

<p>
Вы можете использовать операторы сравнения (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
или <b>=</b>) в начале каждого поля поиска.
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'chat-category-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'slug',
		'title',
		'language',
		'created_at',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

