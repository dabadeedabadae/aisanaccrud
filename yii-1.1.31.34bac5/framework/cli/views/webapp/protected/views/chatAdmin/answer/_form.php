<?php
/* @var $this ChatAdminController */
/* @var $model ChatAnswer */
/* @var $form CActiveForm */
/* @var $categories ChatCategory[] */
/* @var $phrases ChatPhrase[] */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'chat-answer-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'category_id'); ?>
		<?php echo $form->dropDownList($model,'category_id', CHtml::listData($categories, 'id', 'title'), array('empty'=>'Выберите категорию')); ?>
		<?php echo $form->error($model,'category_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'answer_html'); ?>
		<?php echo $form->textArea($model,'answer_html',array('rows'=>10, 'cols'=>80)); ?>
		<?php echo $form->error($model,'answer_html'); ?>
		<p class="hint">Можно использовать HTML теги: &lt;p&gt;, &lt;ul&gt;, &lt;ol&gt;, &lt;li&gt;, &lt;a&gt; и т.д.</p>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'language'); ?>
		<?php echo $form->textField($model,'language',array('size'=>5,'maxlength'=>5, 'value'=>'ru')); ?>
		<?php echo $form->error($model,'language'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_active'); ?>
		<?php echo $form->checkBox($model,'is_active'); ?>
		<?php echo $form->error($model,'is_active'); ?>
	</div>

	<div class="row">
		<label>Фразы для поиска (по одной на строку):</label>
		<textarea name="phrases[]" rows="10" cols="80" placeholder="Введите фразы, по которым бот будет находить этот ответ..."><?php
			if(isset($phrases) && is_array($phrases)):
				foreach($phrases as $phrase):
					echo CHtml::encode($phrase->phrase_text)."\n";
				endforeach;
			endif;
		?></textarea>
		<p class="hint">Каждая строка - отдельная фраза. Бот будет искать совпадения по этим фразам.</p>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

