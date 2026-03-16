<?php
$this->pageTitle = Yii::t('labels', 'Управление курсами');
Yii::app()->clientScript->registerCssFile(
	Yii::app()->baseUrl . '/css/admin.css?v=1.0',
	'screen',
	CClientScript::POS_HEAD
);
Yii::app()->clientScript->registerCssFile(
	Yii::app()->baseUrl . '/css/admin.css?v=1.0',
	'screen',
	CClientScript::POS_HEAD
);
?>

<div class="admin-dashboard">
	<div class="admin-header">
		<h1 class="admin-title"><?= Yii::t('labels', 'Управление курсами') ?></h1>
		<div class="admin-header-actions">
			<?php echo CHtml::link(
				Yii::t('labels', 'Создать курс'),
				array('admin/coursesCreate'),
				array('class' => 'admin-action-btn admin-action-btn-primary')
			); ?>
			<?php echo CHtml::link(
				Yii::t('labels', 'Вернуться в панель'),
				array('admin/dashboard'),
				array('class' => 'admin-action-btn')
			); ?>
		</div>
	</div>

	<?php if(Yii::app()->user->hasFlash('success')): ?>
		<div class="admin-flash-success">
			<?php echo Yii::app()->user->getFlash('success'); ?>
		</div>
	<?php endif; ?>

	<div class="admin-content">
		<?php $this->widget('zii.widgets.grid.CGridView', array(
			'id' => 'courses-grid',
			'dataProvider' => $model->search(),
			'filter' => $model,
			'columns' => array(
				array(
					'name' => 'id',
					'header' => 'ID',
					'htmlOptions' => array('style' => 'width: 60px;'),
				),
				array(
					'name' => 'title',
					'header' => Yii::t('labels', 'Название'),
				),
				array(
					'name' => 'link',
					'header' => Yii::t('labels', 'Ссылка'),
					'type' => 'raw',
					'value' => 'CHtml::link(CHtml::encode($data->link), $data->link, array("target" => "_blank", "style" => "word-break: break-all; overflow-wrap: break-word;"))',
					'htmlOptions' => array('style' => 'max-width: 300px;'),
				),
				array(
					'name' => 'published',
					'header' => Yii::t('labels', 'Опубликовано'),
					'type' => 'boolean',
					'filter' => array('0' => Yii::t('labels', 'Нет'), '1' => Yii::t('labels', 'Да')),
					'htmlOptions' => array('style' => 'width: 100px; text-align: center;'),
				),
				array(
					'name' => 'created_at',
					'header' => Yii::t('labels', 'Дата создания'),
					'value' => 'date("d.m.Y H:i", strtotime($data->created_at))',
					'htmlOptions' => array('style' => 'width: 150px;'),
				),
				array(
					'class' => 'CButtonColumn',
					'header' => Yii::t('labels', 'Действия'),
					'template' => '{view} {update} {delete}',
					'buttons' => array(
						'view' => array(
							'label' => Yii::t('labels', 'Просмотр'),
							'url' => 'Yii::app()->createUrl("admin/coursesView", array("id" => $data->id))',
							'options' => array('class' => 'admin-btn-view'),
						),
						'update' => array(
							'label' => Yii::t('labels', 'Редактировать'),
							'url' => 'Yii::app()->createUrl("admin/coursesUpdate", array("id" => $data->id))',
							'options' => array('class' => 'admin-btn-edit'),
						),
						'delete' => array(
							'label' => Yii::t('labels', 'Удалить'),
							'url' => 'Yii::app()->createUrl("admin/coursesDelete", array("id" => $data->id))',
							'options' => array('class' => 'admin-btn-delete'),
							'click' => 'function(){ return confirm("' . Yii::t('labels', 'Вы уверены, что хотите удалить этот курс?') . '"); }',
						),
					),
					'htmlOptions' => array('style' => 'width: 180px;'),
				),
			),
			'cssFile' => false,
			'pager' => array(
				'class' => 'CLinkPager',
				'cssFile' => false,
			),
		)); ?>
	</div>
</div>

