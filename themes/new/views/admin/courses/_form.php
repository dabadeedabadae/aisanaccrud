<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'course-form',
	'enableAjaxValidation' => false,
)); ?>

	<?php if($form->errorSummary($model)): ?>
		<div class="admin-form-errors">
			<?php echo $form->errorSummary($model); ?>
		</div>
	<?php endif; ?>

	<div class="admin-form-group">
		<?php echo $form->labelEx($model, 'title', array('class' => 'admin-form-label')); ?>
		<?php echo $form->textField($model, 'title', array('class' => 'admin-form-input', 'size' => 60, 'maxlength' => 255, 'placeholder' => Yii::t('labels', 'Введите название курса'))); ?>
		<?php echo $form->error($model, 'title', array('class' => 'admin-form-error')); ?>
	</div>

	<div class="admin-form-group">
		<?php echo $form->labelEx($model, 'description', array('class' => 'admin-form-label')); ?>
		<?php echo $form->textArea($model, 'description', array('class' => 'admin-form-textarea', 'rows' => 4, 'cols' => 60, 'placeholder' => Yii::t('labels', 'Введите описание курса'))); ?>
		<?php echo $form->error($model, 'description', array('class' => 'admin-form-error')); ?>
		<p class="admin-form-hint"><?= Yii::t('labels', 'Краткое описание курса (будет отображаться в списке)') ?></p>
	</div>

	<div class="admin-form-group">
		<?php echo $form->labelEx($model, 'link', array('class' => 'admin-form-label')); ?>
		<?php echo $form->textField($model, 'link', array('class' => 'admin-form-input', 'size' => 60, 'maxlength' => 500, 'placeholder' => 'https://example.com/course')); ?>
		<?php echo $form->error($model, 'link', array('class' => 'admin-form-error')); ?>
		<p class="admin-form-hint"><?= Yii::t('labels', 'Ссылка на курс (полный URL)') ?></p>
	</div>

	<div class="admin-form-group">
		<?php echo $form->labelEx($model, 'published', array('class' => 'admin-form-label')); ?>
		<?php echo $form->checkBox($model, 'published', array('class' => 'admin-form-checkbox')); ?>
		<?php echo $form->error($model, 'published', array('class' => 'admin-form-error')); ?>
		<p class="admin-form-hint"><?= Yii::t('labels', 'Опубликовать курс на сайте') ?></p>
	</div>

	<div class="admin-form-actions">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('labels', 'Создать') : Yii::t('labels', 'Сохранить'), array('class' => 'admin-form-submit')); ?>
		<?php echo CHtml::link(Yii::t('labels', 'Отмена'), array('admin/coursesIndex'), array('class' => 'admin-form-cancel')); ?>
	</div>

<?php $this->endWidget(); ?>



