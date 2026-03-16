<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'news-form',
	'enableAjaxValidation' => false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<?php if($form->errorSummary($model)): ?>
		<div class="admin-form-errors">
			<?php echo $form->errorSummary($model); ?>
		</div>
	<?php endif; ?>

	<div class="admin-form-group">
		<?php echo $form->labelEx($model, 'title', array('class' => 'admin-form-label')); ?>
		<?php echo $form->textField($model, 'title', array('class' => 'admin-form-input', 'size' => 60, 'maxlength' => 255, 'placeholder' => Yii::t('labels', 'Введите название новости'))); ?>
		<?php echo $form->error($model, 'title', array('class' => 'admin-form-error')); ?>
	</div>

	<div class="admin-form-group">
		<?php echo $form->labelEx($model, 'content', array('class' => 'admin-form-label')); ?>
		<?php echo $form->textArea($model, 'content', array('class' => 'admin-form-textarea admin-form-textarea-large', 'rows' => 10, 'cols' => 60, 'placeholder' => Yii::t('labels', 'Введите описание новости'))); ?>
		<?php echo $form->error($model, 'content', array('class' => 'admin-form-error')); ?>
	</div>

	<div class="admin-form-group">
		<?php echo $form->labelEx($model, 'excerpt', array('class' => 'admin-form-label')); ?>
		<?php echo $form->textArea($model, 'excerpt', array('class' => 'admin-form-textarea', 'rows' => 4, 'cols' => 60, 'placeholder' => Yii::t('labels', 'Краткое описание (необязательно)'))); ?>
		<?php echo $form->error($model, 'excerpt', array('class' => 'admin-form-error')); ?>
		<p class="admin-form-hint"><?= Yii::t('labels', 'Краткое описание новости (будет отображаться в списке)') ?></p>
	</div>

	<div class="admin-form-group">
		<?php echo $form->labelEx($model, 'imageFile', array('class' => 'admin-form-label')); ?>
		<?php echo $form->fileField($model, 'imageFile', array('class' => 'admin-form-file')); ?>
		<?php echo $form->error($model, 'imageFile', array('class' => 'admin-form-error')); ?>
		<?php if(!$model->isNewRecord && $model->getImageUrl()): ?>
			<div class="admin-form-image-preview">
				<p class="admin-form-hint"><?= Yii::t('labels', 'Текущее изображение:') ?></p>
				<?php echo CHtml::image($model->getImageUrl(), '', array('class' => 'admin-image-preview')); ?>
			</div>
		<?php endif; ?>
		<p class="admin-form-hint"><?= Yii::t('labels', 'Поддерживаемые форматы: JPG, PNG, GIF, WEBP') ?></p>
	</div>

	<div class="admin-form-group">
		<?php echo $form->labelEx($model, 'published', array('class' => 'admin-form-label')); ?>
		<?php echo $form->checkBox($model, 'published', array('class' => 'admin-form-checkbox')); ?>
		<?php echo $form->error($model, 'published', array('class' => 'admin-form-error')); ?>
		<p class="admin-form-hint"><?= Yii::t('labels', 'Опубликовать новость на сайте') ?></p>
	</div>

	<div class="admin-form-actions">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('labels', 'Создать') : Yii::t('labels', 'Сохранить'), array('class' => 'admin-form-submit')); ?>
		<?php echo CHtml::link(Yii::t('labels', 'Отмена'), array('admin/newsIndex'), array('class' => 'admin-form-cancel')); ?>
	</div>

<?php $this->endWidget(); ?>

