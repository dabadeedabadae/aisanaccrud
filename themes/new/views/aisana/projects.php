<?php
$this->pageTitle = Yii::t('labels', 'Другие проекты');
?>

<section class="courses-section">
	<div class="container">
		<h1 class="courses-page-title"><?= Yii::t('labels', 'Другие проекты') ?></h1>
		
		<?php if(empty($projects)): ?>
			<div class="no-courses">
				<?= Yii::t('labels', 'Проектов пока нет') ?>
			</div>
		<?php else: ?>
			<div class="projects-grid">
				<?php foreach($projects as $project): ?>
					<article class="course-card project-card">
						<?php if($project->getLogoUrl()): ?>
							<div class="project-logo">
								<?php echo CHtml::image($project->getLogoUrl(), $project->title, array('class' => 'project-logo-img')); ?>
							</div>
						<?php endif; ?>

						<div class="course-content">
							<h2 class="course-title">
								<?= CHtml::encode($project->title) ?>
							</h2>
						</div>

						<div class="course-action">
							<a href="<?= Yii::app()->createUrl('aisana/projectView', array('id' => $project->id)) ?>" class="course-btn">
								<?= Yii::t('labels', 'Подробнее') ?>
							</a>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>

