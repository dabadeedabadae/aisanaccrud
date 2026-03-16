<?php
$this->pageTitle = CHtml::encode($news->title);
?>

<section class="news-section">
	<div class="container">
		<article class="news-single">
			<div class="news-single-header">
				<a href="<?= Yii::app()->createUrl('aisana/news') ?>" class="news-back-link">
					← <?= Yii::t('labels', 'Вернуться к новостям') ?>
				</a>
				<span class="news-single-date">
					<?php
					$months = array(
						'ru' => array('января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 
							'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'),
						'kz' => array('қаңтар', 'ақпан', 'наурыз', 'сәуір', 'мамыр', 'маусым',
							'шілде', 'тамыз', 'қыркүйек', 'қазан', 'қараша', 'желтоқсан'),
						'en' => array('January', 'February', 'March', 'April', 'May', 'June',
							'July', 'August', 'September', 'October', 'November', 'December')
					);
					$lang = Yii::app()->language;
					$monthNames = isset($months[$lang]) ? $months[$lang] : $months['ru'];
					$timestamp = strtotime($news->created_at);
					$day = date('d', $timestamp);
					$month = $monthNames[date('n', $timestamp) - 1];
					$year = date('Y', $timestamp);
					echo $day . ' ' . $month . ' ' . $year;
					?>
				</span>
			</div>
			
			<h1 class="news-single-title"><?= CHtml::encode($news->title) ?></h1>
			
			<?php if($news->getImageUrl()): ?>
				<div class="news-single-image">
					<img src="<?= $news->getImageUrl() ?>" alt="<?= CHtml::encode($news->title) ?>">
				</div>
			<?php endif; ?>
			
			<div class="news-single-content">
				<?php if(!empty($news->excerpt)): ?>
					<div class="news-single-excerpt">
						<?= nl2br(CHtml::encode($news->excerpt)) ?>
					</div>
				<?php endif; ?>
				
				<div class="news-single-text">
					<?= nl2br(CHtml::encode($news->content)) ?>
				</div>
			</div>
			
			<div class="news-single-footer">
				<a href="<?= Yii::app()->createUrl('aisana/news') ?>" class="news-btn">
					← <?= Yii::t('labels', 'Вернуться к новостям') ?>
				</a>
			</div>
		</article>
	</div>
</section>



