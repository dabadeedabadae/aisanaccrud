<?php
$this->pageTitle = Yii::t('labels', 'Новости');
?>

<section class="news-section">
	<div class="container">
		<h1 class="news-page-title"><?= Yii::t('labels', 'Новости') ?></h1>
		
		<?php if(empty($news)): ?>
			<div class="no-news">
				<?= Yii::t('labels', 'Новостей пока нет') ?>
			</div>
		<?php else: ?>
			<div class="news-grid">
				<?php foreach($news as $item): ?>
					<article class="news-card">
						<?php if($item->getImageUrl()): ?>
							<div class="news-image">
								<a href="<?= Yii::app()->createUrl('aisana/newsView', array('slug' => $item->slug)) ?>">
									<img src="<?= $item->getImageUrl() ?>" alt="<?= CHtml::encode($item->title) ?>">
								</a>
							</div>
						<?php endif; ?>
						
						<div class="news-content">
							<h2 class="news-title">
								<a href="<?= Yii::app()->createUrl('aisana/newsView', array('slug' => $item->slug)) ?>">
									<?= CHtml::encode($item->title) ?>
								</a>
							</h2>
							
							<?php if(!empty($item->excerpt)): ?>
								<div class="news-excerpt">
									<?= nl2br(CHtml::encode($item->excerpt)) ?>
								</div>
							<?php elseif(!empty($item->content)): ?>
								<div class="news-excerpt">
									<?= nl2br(CHtml::encode(mb_substr(strip_tags($item->content), 0, 200))) ?>...
								</div>
							<?php endif; ?>
							
							<div class="news-footer">
								<span class="news-date">
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
									$timestamp = strtotime($item->created_at);
									$day = date('d', $timestamp);
									$month = $monthNames[date('n', $timestamp) - 1];
									$year = date('Y', $timestamp);
									echo $day . ' ' . $month . ' ' . $year;
									?>
								</span>
								<a href="<?= Yii::app()->createUrl('aisana/newsView', array('slug' => $item->slug)) ?>" class="news-btn">
									<?= Yii::t('labels', 'Подробнее') ?>
								</a>
							</div>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>

