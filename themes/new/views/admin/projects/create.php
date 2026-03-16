<?php
$this->pageTitle = Yii::t('labels', 'Создать проект');
$this->breadcrumbs = array(
	Yii::t('labels', 'Управление проектами') => array('admin/projectsIndex'),
	Yii::t('labels', 'Создать проект'),
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
// Cropper.js CSS
Yii::app()->clientScript->registerCssFile(
	'https://cdn.jsdelivr.net/npm/cropperjs@1.5.13/dist/cropper.min.css',
	'screen',
	CClientScript::POS_HEAD
);
// Cropper.js JS
Yii::app()->clientScript->registerScriptFile(
	'https://cdn.jsdelivr.net/npm/cropperjs@1.5.13/dist/cropper.min.js',
	CClientScript::POS_END
);
?>

<div class="admin-dashboard">
	<div class="admin-header">
		<h1 class="admin-title"><?= Yii::t('labels', 'Создать проект') ?></h1>
		<?php echo CHtml::link(
			Yii::t('labels', 'Вернуться к списку'),
			array('admin/projectsIndex'),
			array('class' => 'admin-action-btn')
		); ?>
	</div>

	<div class="admin-content">
		<?php 
		$formPath = Yii::app()->theme->getViewPath() . '/admin/projects/_form.php';
		$this->renderFile($formPath, array('model' => $model));
		?>
	</div>
</div>

