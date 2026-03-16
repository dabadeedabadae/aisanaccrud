<?php
$this->pageTitle = CHtml::encode($project->title);

?>

<section class="courses-section">
	<div class="container">
		<div class="project-detail">
			<div class="project-detail-header">
				<a href="<?= Yii::app()->createUrl('aisana/projects') ?>" class="news-back-link">
					← <?= Yii::t('labels', 'Вернуться к проектам') ?>
				</a>
			</div>
			
			<div class="project-detail-content">
				<div class="project-detail-top">
				<?php if($project->getLogoUrl()): ?>
					<div class="project-detail-logo">
						<?php echo CHtml::image($project->getLogoUrl(), $project->title, array('class' => 'project-detail-logo-img')); ?>
					</div>
				<?php endif; ?>
					
					<div class="project-detail-title-description">
						<h1 class="project-detail-title"><?= CHtml::encode($project->title) ?></h1>
						
						<div class="project-detail-description">
							<?= nl2br(CHtml::encode($project->description)) ?>
						</div>
					</div>
				</div>
				
				<?php if(!empty($project->goals)): ?>
					<div class="project-detail-section">
						<h2 class="project-detail-section-title"><?= Yii::t('labels', 'Цели') ?></h2>
						<div class="project-detail-section-content">
							<?= nl2br(CHtml::encode($project->goals)) ?>
						</div>
					</div>
				<?php endif; ?>
				
				<?php if(!empty($project->developers)): ?>
					<div class="project-detail-section">
						<h2 class="project-detail-section-title"><?= Yii::t('labels', 'Разработчики') ?></h2>
						<div class="project-detail-section-content">
							<?= nl2br(CHtml::encode($project->developers)) ?>
						</div>
					</div>
				<?php endif; ?>
				
				<?php 
				$screenshots = $project->getScreenshotsArray();
				if(!empty($screenshots)): 
				?>
					<div class="project-detail-section">
						<h2 class="project-detail-section-title"><?= Yii::t('labels', 'Скриншоты') ?></h2>
						<div class="project-detail-screenshots" id="project-screenshots-gallery">
							<?php foreach($screenshots as $index => $screenshot): ?>
								<div class="project-detail-screenshot-item" data-screenshot-index="<?= $index ?>" data-screenshot-url="<?= CHtml::encode($screenshot) ?>">
									<?php echo CHtml::image($screenshot, '', array('class' => 'project-detail-screenshot-img')); ?>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
					
					<!-- Модальное окно для просмотра скриншотов -->
					<div id="screenshot-modal" class="screenshot-modal">
						<div class="screenshot-modal-overlay"></div>
						<div class="screenshot-modal-content">
							<button class="screenshot-modal-close" id="screenshot-modal-close">&times;</button>
							<button class="screenshot-modal-nav screenshot-modal-prev" id="screenshot-modal-prev">‹</button>
							<button class="screenshot-modal-nav screenshot-modal-next" id="screenshot-modal-next">›</button>
							<div class="screenshot-modal-image-container">
								<img id="screenshot-modal-image" src="" alt="">
							</div>
							<div class="screenshot-modal-counter">
								<span id="screenshot-current">1</span> / <span id="screenshot-total"><?= count($screenshots) ?></span>
							</div>
						</div>
					</div>
				<?php endif; ?>
				
				<?php if(!empty($project->contacts)): ?>
					<div class="project-detail-section">
						<h2 class="project-detail-section-title"><?= Yii::t('labels', 'Контакты для сотрудничества') ?></h2>
						<div class="project-detail-section-content project-detail-contacts">
							<?= nl2br(CHtml::encode($project->contacts)) ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
			
			<div class="project-detail-footer">
				<a href="<?= Yii::app()->createUrl('aisana/projects') ?>" class="news-btn">
					← <?= Yii::t('labels', 'Вернуться к проектам') ?>
				</a>
			</div>
		</div>
	</div>
</section>

