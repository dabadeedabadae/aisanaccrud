<?php
$this->pageTitle = Yii::t('labels', 'Вход в админ-панель');
Yii::app()->clientScript->registerCssFile(
	Yii::app()->baseUrl . '/css/admin.css?v=1.0',
	'screen',
	CClientScript::POS_HEAD
);
?>

<div class="admin-login-container">
	<div class="admin-login-box">
		<h1 class="admin-login-title"><?= Yii::t('labels', 'Вход в админ-панель') ?></h1>
		
		<?php $form = $this->beginWidget('CActiveForm', array(
			'id' => 'login-form',
			'enableClientValidation' => true,
			'clientOptions' => array(
				'validateOnSubmit' => true,
			),
			'htmlOptions' => array('class' => 'admin-login-form'),
		)); ?>

		<?php if($form->errorSummary($model)): ?>
			<div class="admin-form-errors">
				<?php echo $form->errorSummary($model); ?>
			</div>
		<?php endif; ?>

		<div class="form-group">
			<?php echo $form->labelEx($model, 'username', array('class' => 'form-label')); ?>
			<?php echo $form->textField($model, 'username', array('class' => 'form-input', 'autocomplete' => 'username', 'placeholder' => Yii::t('labels', 'Введите логин'))); ?>
			<?php echo $form->error($model, 'username', array('class' => 'form-error')); ?>
		</div>

		<div class="form-group">
			<?php echo $form->labelEx($model, 'password', array('class' => 'form-label')); ?>
			<?php echo $form->passwordField($model, 'password', array('class' => 'form-input', 'autocomplete' => 'current-password', 'placeholder' => Yii::t('labels', 'Введите пароль'))); ?>
			<?php echo $form->error($model, 'password', array('class' => 'form-error')); ?>
		</div>

		<div class="form-group checkbox-group">
			<?php echo $form->checkBox($model, 'rememberMe', array('class' => 'form-checkbox')); ?>
			<?php echo $form->label($model, 'rememberMe', array('class' => 'form-checkbox-label')); ?>
			<?php echo $form->error($model, 'rememberMe', array('class' => 'form-error')); ?>
		</div>

		<div class="form-group">
			<?php echo CHtml::submitButton(Yii::t('labels', 'Войти'), array('class' => 'admin-login-btn')); ?>
		</div>

		<?php $this->endWidget(); ?>
		
		<div class="admin-login-footer">
			<a href="<?= Yii::app()->createUrl('aisana/index') ?>" class="admin-back-link">
				← <?= Yii::t('labels', 'Вернуться на главную') ?>
			</a>
		</div>
	</div>
</div>


