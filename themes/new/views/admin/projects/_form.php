<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'project-form',
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
		<?php echo $form->textField($model, 'title', array('class' => 'admin-form-input', 'size' => 60, 'maxlength' => 255, 'placeholder' => Yii::t('labels', 'Введите название проекта'))); ?>
		<?php echo $form->error($model, 'title', array('class' => 'admin-form-error')); ?>
	</div>

	<div class="admin-form-group">
		<?php echo $form->labelEx($model, 'description', array('class' => 'admin-form-label')); ?>
		<?php echo $form->textArea($model, 'description', array('class' => 'admin-form-textarea admin-form-textarea-large', 'rows' => 10, 'cols' => 60, 'placeholder' => Yii::t('labels', 'Введите описание проекта'))); ?>
		<?php echo $form->error($model, 'description', array('class' => 'admin-form-error')); ?>
		<p class="admin-form-hint"><?= Yii::t('labels', 'Краткое описание проекта (будет отображаться в списке)') ?></p>
	</div>

	<div class="admin-form-group">
		<?php echo $form->labelEx($model, 'goals', array('class' => 'admin-form-label')); ?>
		<?php echo $form->textArea($model, 'goals', array('class' => 'admin-form-textarea admin-form-textarea-large', 'rows' => 6, 'cols' => 60, 'placeholder' => Yii::t('labels', 'Введите цели проекта (опционально)'))); ?>
		<?php echo $form->error($model, 'goals', array('class' => 'admin-form-error')); ?>
		<p class="admin-form-hint"><?= Yii::t('labels', 'Цели проекта (опционально, будет отображаться на странице проекта)') ?></p>
	</div>

	<div class="admin-form-group">
		<?php echo $form->labelEx($model, 'developers', array('class' => 'admin-form-label')); ?>
		<?php echo $form->textArea($model, 'developers', array('class' => 'admin-form-textarea', 'rows' => 4, 'cols' => 60, 'placeholder' => Yii::t('labels', 'Введите информацию о разработчиках (опционально)'))); ?>
		<?php echo $form->error($model, 'developers', array('class' => 'admin-form-error')); ?>
		<p class="admin-form-hint"><?= Yii::t('labels', 'Информация о разработчиках (опционально, будет отображаться на странице проекта)') ?></p>
	</div>

	<div class="admin-form-group">
		<?php echo $form->labelEx($model, 'contacts', array('class' => 'admin-form-label')); ?>
		<?php echo $form->textArea($model, 'contacts', array('class' => 'admin-form-textarea', 'rows' => 4, 'cols' => 60, 'placeholder' => Yii::t('labels', 'Введите контакты для сотрудничества (опционально)'))); ?>
		<?php echo $form->error($model, 'contacts', array('class' => 'admin-form-error')); ?>
		<p class="admin-form-hint"><?= Yii::t('labels', 'Контакты для сотрудничества (опционально, будет отображаться на странице проекта)') ?></p>
	</div>

	<div class="admin-form-group">
		<?php echo $form->labelEx($model, 'logoFile', array('class' => 'admin-form-label')); ?>
		<?php echo $form->fileField($model, 'logoFile', array('class' => 'admin-form-file', 'id' => 'logo-file-input', 'accept' => 'image/*')); ?>
		<?php echo $form->error($model, 'logoFile', array('class' => 'admin-form-error')); ?>
		
		<!-- Контейнер для обрезки изображения -->
		<div id="logo-cropper-container" style="display: none; margin-top: 20px;">
			<div style="max-width: 500px; margin: 0 auto;">
				<img id="logo-cropper-image" src="" style="max-width: 100%; display: block;">
			</div>
			<div style="text-align: center; margin-top: 15px;">
				<button type="button" id="logo-crop-btn" class="admin-action-btn admin-action-btn-primary" style="display: none;">
					<?= Yii::t('labels', 'Обрезать логотип') ?>
				</button>
				<button type="button" id="logo-cancel-crop-btn" class="admin-action-btn" style="display: none; margin-left: 10px;">
					<?= Yii::t('labels', 'Отмена') ?>
				</button>
			</div>
		</div>
		
		<!-- Скрытое поле для обрезанного изображения -->
		<input type="hidden" id="logo-cropped-data" name="Project[croppedLogo]" value="">
		
		<?php if(!$model->isNewRecord && $model->getLogoUrl()): ?>
			<div class="admin-form-image-preview">
				<p class="admin-form-hint"><?= Yii::t('labels', 'Текущий логотип:') ?></p>
				<?php echo CHtml::image($model->getLogoUrl(), '', array('class' => 'admin-image-preview', 'id' => 'current-logo-preview')); ?>
			</div>
		<?php endif; ?>
		<p class="admin-form-hint"><?= Yii::t('labels', 'Поддерживаемые форматы: JPG, PNG, GIF, WEBP (опционально). Логотип будет обрезан до квадрата.') ?></p>
	</div>

	<div class="admin-form-group">
		<?php echo $form->labelEx($model, 'screenshotFiles', array('class' => 'admin-form-label')); ?>
		<?php echo CHtml::fileField('Project[screenshotFiles][]', '', array('class' => 'admin-form-file', 'multiple' => 'multiple')); ?>
		<?php echo $form->error($model, 'screenshotFiles', array('class' => 'admin-form-error')); ?>
		<p class="admin-form-hint"><?= Yii::t('labels', 'Можно загрузить несколько файлов одновременно (опционально)') ?></p>
		<p class="admin-form-hint"><?= Yii::t('labels', 'Поддерживаемые форматы: JPG, PNG, GIF, WEBP') ?></p>
		
		<?php if(!$model->isNewRecord): 
			$screenshots = $model->getScreenshotsArray();
			if(!empty($screenshots)): 
		?>
			<div class="admin-form-screenshots">
				<p class="admin-form-hint"><?= Yii::t('labels', 'Текущие скриншоты:') ?></p>
				<div class="admin-screenshots-grid">
					<?php foreach($screenshots as $index => $screenshot): ?>
						<div class="admin-screenshot-item">
							<?php echo CHtml::image($screenshot, '', array('class' => 'admin-image-preview')); ?>
							<?php echo CHtml::link(
								Yii::t('labels', 'Удалить'),
								array('admin/projectsDeleteScreenshot', 'id' => $model->id, 'index' => $index),
								array(
									'class' => 'admin-btn-delete',
									'confirm' => Yii::t('labels', 'Вы уверены, что хотите удалить этот скриншот?'),
									'style' => 'display: block; margin-top: 5px; text-align: center;'
								)
							); ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; endif; ?>
	</div>

	<div class="admin-form-group">
		<?php echo $form->labelEx($model, 'published', array('class' => 'admin-form-label')); ?>
		<?php echo $form->checkBox($model, 'published', array('class' => 'admin-form-checkbox')); ?>
		<?php echo $form->error($model, 'published', array('class' => 'admin-form-error')); ?>
		<p class="admin-form-hint"><?= Yii::t('labels', 'Опубликовать проект на сайте') ?></p>
	</div>

	<div class="admin-form-actions">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('labels', 'Создать') : Yii::t('labels', 'Сохранить'), array('class' => 'admin-form-submit')); ?>
		<?php echo CHtml::link(Yii::t('labels', 'Отмена'), array('admin/projectsIndex'), array('class' => 'admin-form-cancel')); ?>
	</div>

<?php $this->endWidget(); ?>

