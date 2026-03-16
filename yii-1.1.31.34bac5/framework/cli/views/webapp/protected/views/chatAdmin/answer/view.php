<?php
/* @var $this ChatAdminController */
/* @var $model ChatAnswer */

$this->breadcrumbs=array(
	'Чат-бот' => array('index'),
	'Ответы' => array('answerIndex'),
	$model->title,
);

$this->menu=array(
	array('label'=>'Создать ответ', 'url'=>array('answerCreate')),
	array('label'=>'Управление категориями', 'url'=>array('categoryIndex')),
	array('label'=>'Управление ответами', 'url'=>array('answerIndex')),
	array('label'=>'Редактировать', 'url'=>array('answerUpdate', 'id'=>$model->id)),
	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('answerDelete','id'=>$model->id),'confirm'=>'Вы уверены, что хотите удалить этот элемент?')),
	array('label'=>'Статистика', 'url'=>array('stats')),
);
?>

<h1>Просмотр ответа #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array(
			'name'=>'category_id',
			'value'=>$model->category ? $model->category->title : '',
		),
		'title',
		array(
			'name'=>'answer_html',
			'type'=>'raw',
			'value'=>$model->answer_html,
		),
		'language',
		array(
			'name'=>'is_active',
			'value'=>$model->is_active ? 'Да' : 'Нет',
		),
		'created_at',
		'updated_at',
	),
)); ?>

<h2>Фразы для поиска</h2>
<?php
$phrases = ChatPhrase::model()->findAllByAttributes(array('answer_id' => $model->id));
if(empty($phrases)):
	echo '<p>Нет фраз для этого ответа.</p>';
else:
	echo '<ul>';
	foreach($phrases as $phrase):
		echo '<li>'.CHtml::encode($phrase->phrase_text).'</li>';
	endforeach;
	echo '</ul>';
endif;
?>

<h2>Статистика</h2>
<p>Количество запросов: <strong><?php echo $model->statsCount; ?></strong></p>

