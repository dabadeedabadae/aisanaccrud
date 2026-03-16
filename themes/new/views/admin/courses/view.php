<?php
$this->pageTitle = Yii::t('labels', 'Просмотр курса');
$this->breadcrumbs = array(
	Yii::t('labels', 'Управление курсами') => array('admin/coursesIndex'),
	Yii::t('labels', 'Просмотр курса'),
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
		<h1 class="admin-title"><?= Yii::t('labels', 'Просмотр курса') ?></h1>
		<div class="admin-header-actions">
			<?php echo CHtml::link(
				Yii::t('labels', 'Редактировать'),
				array('admin/coursesUpdate', 'id' => $model->id),
				array('class' => 'admin-action-btn admin-action-btn-primary')
			); ?>
			<?php echo CHtml::link(
				Yii::t('labels', 'Вернуться к списку'),
				array('admin/coursesIndex'),
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
				<label class="admin-view-label"><?= Yii::t('labels', 'Название курса') ?>:</label>
				<div class="admin-view-value"><?= CHtml::encode($model->title) ?></div>
			</div>

			<div class="admin-view-field">
				<label class="admin-view-label"><?= Yii::t('labels', 'Описание') ?>:</label>
				<div class="admin-view-value admin-view-content"><?= nl2br(CHtml::encode($model->description)) ?></div>
			</div>

			<div class="admin-view-field">
				<label class="admin-view-label"><?= Yii::t('labels', 'Ссылка на курс') ?>:</label>
				<div class="admin-view-value">
					<a href="<?= CHtml::encode($model->link) ?>" target="_blank" rel="noopener noreferrer">
						<?= CHtml::encode($model->link) ?>
					</a>
				</div>
			</div>

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



