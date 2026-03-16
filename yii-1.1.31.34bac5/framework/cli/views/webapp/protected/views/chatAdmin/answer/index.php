<?php
/* @var $this ChatAdminController */
/* @var $model ChatAnswer */

$this->breadcrumbs=array(
	'Чат-бот' => array('index'),
	'Ответы',
);

$this->menu=array(
	array('label'=>'Создать ответ', 'url'=>array('answerCreate')),
	array('label'=>'Управление категориями', 'url'=>array('categoryIndex')),
	array('label'=>'Управление ответами', 'url'=>array('answerIndex'), 'active'=>true),
	array('label'=>'Статистика', 'url'=>array('stats')),
);
?>

<h1>Управление ответами</h1>

<p>
Вы можете использовать операторы сравнения (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
или <b>=</b>) в начале каждого поля поиска.
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'chat-answer-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		array(
			'name'=>'category_id',
			'value'=>'$data->category ? $data->category->title : ""',
			'filter'=>CHtml::listData(ChatCategory::model()->findAll(), 'id', 'title'),
		),
		'title',
		'language',
		array(
			'name'=>'is_active',
			'value'=>'$data->is_active ? "Да" : "Нет"',
			'filter'=>array(1=>'Да', 0=>'Нет'),
		),
		'created_at',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

