<?php
$this->pageTitle = Yii::t('labels', 'Создать курс');
$this->breadcrumbs = array(
	Yii::t('labels', 'Управление курсами') => array('admin/coursesIndex'),
	Yii::t('labels', 'Создать курс'),
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
		<h1 class="admin-title"><?= Yii::t('labels', 'Создать курс') ?></h1>
		<?php echo CHtml::link(
			Yii::t('labels', 'Вернуться к списку'),
			array('admin/coursesIndex'),
			array('class' => 'admin-action-btn')
		); ?>
	</div>

	<div class="admin-content">
		<?php 
		$formPath = Yii::app()->theme->getViewPath() . '/admin/courses/_form.php';
		$this->renderFile($formPath, array('model' => $model));
		?>
	</div>
</div>



