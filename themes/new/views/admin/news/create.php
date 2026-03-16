<?php
$this->pageTitle = Yii::t('labels', 'Создать новость');
$this->breadcrumbs = array(
	Yii::t('labels', 'Управление новостями') => array('admin/newsIndex'),
	Yii::t('labels', 'Создать новость'),
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
		<h1 class="admin-title"><?= Yii::t('labels', 'Создать новость') ?></h1>
		<?php echo CHtml::link(
			Yii::t('labels', 'Вернуться к списку'),
			array('admin/newsIndex'),
			array('class' => 'admin-action-btn')
		); ?>
	</div>

	<div class="admin-content">
		<?php 
		$formPath = Yii::app()->theme->getViewPath() . '/admin/news/_form.php';
		$this->renderFile($formPath, array('model' => $model));
		?>
	</div>
</div>

