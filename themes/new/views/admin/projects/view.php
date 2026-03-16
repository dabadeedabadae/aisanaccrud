<?php
$this->pageTitle = Yii::t('labels', 'Просмотр проекта');
$this->breadcrumbs = array(
	Yii::t('labels', 'Управление проектами') => array('admin/projectsIndex'),
	Yii::t('labels', 'Просмотр проекта'),
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
		<h1 class="admin-title"><?= Yii::t('labels', 'Просмотр проекта') ?></h1>
		<div class="admin-header-actions">
			<?php echo CHtml::link(
				Yii::t('labels', 'Редактировать'),
				array('admin/projectsUpdate', 'id' => $model->id),
				array('class' => 'admin-action-btn admin-action-btn-primary')
			); ?>
			<?php echo CHtml::link(
				Yii::t('labels', 'Вернуться к списку'),
				array('admin/projectsIndex'),
				array('class' => 'admin-action-btn')
			); ?>
		</div>
	</div>

	<div class="admin-content">
		<div class="admin-view">
			<div class="admin-view-row">
				<div class="admin-view-label"><?= Yii::t('labels', 'ID') ?>:</div>
				<div class="admin-view-value"><?= $model->id ?></div>
			</div>
			
			<div class="admin-view-row">
				<div class="admin-view-label"><?= Yii::t('labels', 'Название') ?>:</div>
				<div class="admin-view-value"><?= CHtml::encode($model->title) ?></div>
			</div>
			
			<div class="admin-view-row">
				<div class="admin-view-label"><?= Yii::t('labels', 'Описание') ?>:</div>
				<div class="admin-view-value"><?= nl2br(CHtml::encode($model->description)) ?></div>
			</div>
			
			<?php if(!empty($model->goals)): ?>
			<div class="admin-view-row">
				<div class="admin-view-label"><?= Yii::t('labels', 'Цели') ?>:</div>
				<div class="admin-view-value"><?= nl2br(CHtml::encode($model->goals)) ?></div>
			</div>
			<?php endif; ?>
			
			<?php if(!empty($model->developers)): ?>
			<div class="admin-view-row">
				<div class="admin-view-label"><?= Yii::t('labels', 'Разработчики') ?>:</div>
				<div class="admin-view-value"><?= nl2br(CHtml::encode($model->developers)) ?></div>
			</div>
			<?php endif; ?>
			
			<?php if(!empty($model->contacts)): ?>
			<div class="admin-view-row">
				<div class="admin-view-label"><?= Yii::t('labels', 'Контакты для сотрудничества') ?>:</div>
				<div class="admin-view-value"><?= nl2br(CHtml::encode($model->contacts)) ?></div>
			</div>
			<?php endif; ?>
			
			<?php if($model->getLogoUrl()): ?>
			<div class="admin-view-row">
				<div class="admin-view-label"><?= Yii::t('labels', 'Логотип') ?>:</div>
				<div class="admin-view-value">
					<?php echo CHtml::image($model->getLogoUrl(), '', array('class' => 'admin-image-preview')); ?>
				</div>
			</div>
			<?php endif; ?>
			
			<?php 
			$screenshots = $model->getScreenshotsArray();
			if(!empty($screenshots)): 
			?>
			<div class="admin-view-row">
				<div class="admin-view-label"><?= Yii::t('labels', 'Скриншоты') ?>:</div>
				<div class="admin-view-value">
					<div class="admin-screenshots-grid">
						<?php foreach($screenshots as $screenshot): ?>
							<div class="admin-screenshot-item">
								<?php echo CHtml::image($screenshot, '', array('class' => 'admin-image-preview')); ?>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
			<?php endif; ?>
			
			<div class="admin-view-row">
				<div class="admin-view-label"><?= Yii::t('labels', 'Опубликовано') ?>:</div>
				<div class="admin-view-value"><?= $model->published ? Yii::t('labels', 'Да') : Yii::t('labels', 'Нет') ?></div>
			</div>
			
			<div class="admin-view-row">
				<div class="admin-view-label"><?= Yii::t('labels', 'Дата создания') ?>:</div>
				<div class="admin-view-value"><?= date('d.m.Y H:i', strtotime($model->created_at)) ?></div>
			</div>
			
			<div class="admin-view-row">
				<div class="admin-view-label"><?= Yii::t('labels', 'Дата обновления') ?>:</div>
				<div class="admin-view-value"><?= date('d.m.Y H:i', strtotime($model->updated_at)) ?></div>
			</div>
		</div>
	</div>
</div>

