<?php
/* @var $this ChatAdminController */
/* @var $model ChatCategory */

$this->breadcrumbs=array(
	'Чат-бот' => array('index'),
	'Категории' => array('categoryIndex'),
	$model->title,
);

$this->menu=array(
	array('label'=>'Создать категорию', 'url'=>array('categoryCreate')),
	array('label'=>'Управление категориями', 'url'=>array('categoryIndex')),
	array('label'=>'Редактировать', 'url'=>array('categoryUpdate', 'id'=>$model->id)),
	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('categoryDelete','id'=>$model->id),'confirm'=>'Вы уверены, что хотите удалить этот элемент?')),
	array('label'=>'Управление ответами', 'url'=>array('answerIndex')),
	array('label'=>'Статистика', 'url'=>array('stats')),
);
?>

<h1>Просмотр категории #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'slug',
		'title',
		'language',
		'created_at',
		'updated_at',
	),
)); ?>

<h2>Ответы в этой категории</h2>
<?php
$answers = ChatAnswer::model()->findAllByAttributes(array('category_id' => $model->id));
if(empty($answers)):
	echo '<p>Нет ответов в этой категории.</p>';
else:
	echo '<ul>';
	foreach($answers as $answer):
		echo '<li>'.CHtml::link(CHtml::encode($answer->title), array('answerView', 'id'=>$answer->id)).'</li>';
	endforeach;
	echo '</ul>';
endif;
?>

