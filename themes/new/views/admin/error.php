<?php
$this->pageTitle = Yii::t('labels', 'Ошибка');
Yii::app()->clientScript->registerCssFile(
	Yii::app()->baseUrl . '/css/admin.css?v=1.0',
	'screen',
	CClientScript::POS_HEAD
);
?>

<div class="admin-error-container">
	<div class="admin-error-box">
		<h1 class="admin-error-title"><?= CHtml::encode($code) ?></h1>
		<div class="admin-error-message">
			<?= CHtml::encode($message) ?>
		</div>
		<div class="admin-error-actions">
			<a href="<?= Yii::app()->createUrl('admin/dashboard') ?>" class="admin-back-btn">
				<?= Yii::t('labels', 'Вернуться в админ-панель') ?>
			</a>
		</div>
	</div>
</div>


