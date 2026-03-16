<?php
$this->pageTitle = Yii::t('labels', 'Просмотр новости');
$this->breadcrumbs = array(
	Yii::t('labels', 'Управление новостями') => array('admin/newsIndex'),
	Yii::t('labels', 'Просмотр новости'),
);
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
		<h1 class="admin-title"><?= Yii::t('labels', 'Просмотр новости') ?></h1>
		<div class="admin-header-actions">
			<?php echo CHtml::link(
				Yii::t('labels', 'Редактировать'),
				array('admin/newsUpdate', 'id' => $model->id),
				array('class' => 'admin-action-btn admin-action-btn-primary')
			); ?>
			<?php echo CHtml::link(
				Yii::t('labels', 'Вернуться к списку'),
				array('admin/newsIndex'),
				array('class' => 'admin-action-btn')
			); ?>
		</div>
	</div>

	<div class="admin-content">
		<div class="admin-view">
			<div class="admin-view-field">
				<label class="admin-view-label"><?= Yii::t('labels', 'ID') ?>:</label>
				<div class="admin-view-value"><?= CHtml::encode($model->id) ?></div>
			</div>

			<div class="admin-view-field">
				<label class="admin-view-label"><?= Yii::t('labels', 'Заголовок') ?>:</label>
				<div class="admin-view-value"><?= CHtml::encode($model->title) ?></div>
			</div>

			<div class="admin-view-field">
				<label class="admin-view-label"><?= Yii::t('labels', 'Краткое описание') ?>:</label>
				<div class="admin-view-value"><?= nl2br(CHtml::encode($model->excerpt)) ?></div>
			</div>

			<div class="admin-view-field">
				<label class="admin-view-label"><?= Yii::t('labels', 'Содержание') ?>:</label>
				<div class="admin-view-value admin-view-content"><?= nl2br(CHtml::encode($model->content)) ?></div>
			</div>

			<?php if($model->getImageUrl()): ?>
			<div class="admin-view-field">
				<label class="admin-view-label"><?= Yii::t('labels', 'Изображение') ?>:</label>
				<div class="admin-view-value">
					<?php echo CHtml::image($model->getImageUrl(), '', array('class' => 'admin-view-image')); ?>
				</div>
			</div>
			<?php endif; ?>

			<div class="admin-view-field">
				<label class="admin-view-label"><?= Yii::t('labels', 'Опубликовано') ?>:</label>
				<div class="admin-view-value">
					<?= $model->published ? Yii::t('labels', 'Да') : Yii::t('labels', 'Нет') ?>
				</div>
			</div>

			<div class="admin-view-field">
				<label class="admin-view-label"><?= Yii::t('labels', 'Дата создания') ?>:</label>
				<div class="admin-view-value"><?= date('d.m.Y H:i:s', strtotime($model->created_at)) ?></div>
			</div>

			<div class="admin-view-field">
				<label class="admin-view-label"><?= Yii::t('labels', 'Дата обновления') ?>:</label>
				<div class="admin-view-value"><?= date('d.m.Y H:i:s', strtotime($model->updated_at)) ?></div>
			</div>
		</div>
	</div>
</div>


