<?php
$this->pageTitle = Yii::t('labels', 'Курсы для вас');
?>

<section class="courses-section">
	<div class="container">
		<h1 class="courses-page-title"><?= Yii::t('labels', 'Курсы для вас') ?></h1>
		
		<?php if(empty($courses)): ?>
			<div class="no-courses">
				<?= Yii::t('labels', 'Курсов пока нет') ?>
			</div>
		<?php else: ?>
			<div class="courses-list">
				<?php foreach($courses as $course): ?>
					<article class="course-card">
						<div class="course-content">
							<h2 class="course-title">
								<a href="<?= CHtml::encode($course->link) ?>" target="_blank" rel="noopener noreferrer">
									<?= CHtml::encode($course->title) ?>
								</a>
							</h2>
							
							<div class="course-description">
								<?= nl2br(CHtml::encode($course->description)) ?>
							</div>
						</div>
						
						<div class="course-action">
							<a href="<?= CHtml::encode($course->link) ?>" target="_blank" rel="noopener noreferrer" class="course-btn">
								<?= Yii::t('labels', 'Подробнее') ?>
							</a>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>



