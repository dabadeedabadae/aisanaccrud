<?php
$this->pageTitle = Yii::t('labels', 'AI Sana Kozybayev University');
?>

<section class="main-section">
	<section class="container main-content-container">
		<div class="center-box">
			<p class="center-box-subtitle"><?= Yii::t('labels', 'AI Sana Kozybayev University') ?></p>
			<h1><?= Yii::t('labels', 'Интеллектуальные AI-агенты для университета и города') ?></h1>
			<p class="center-box-text"><?= Yii::t('labels', 'Новые возможности автоматизации — от диагностики пациентов до оптимизации городского транспорта и работы с документами') ?></p>
		</div>
		<a href="#ai-agents-section" class="more-btn"><?= Yii::t('labels', 'Подробнее') ?></a>
	</section>
	
	<?php $this->renderPartial('parts/_agents'); ?>
	
	<section class="container about-section" id="about-program-section">
		<h2 class="section-title"><?= Yii::t('labels', 'О программе AI SANA') ?></h2>
		<div class="about-content">
			<div class="about-text">
				<p><?= Yii::t('labels', 'Программа AI SANA — инициатива Министерства науки и высшего образования для внедрения передовых технологий искусственного интеллекта в образование.') ?></p>
				<p><?= Yii::t('labels', 'Охватывает 100 000 студентов, стимулирует создание DeepTech-стартапов, развитие ИИ-компетенций и технологического предпринимательства.') ?></p>
				<p><?= Yii::t('labels', 'Проходит в 3 этапа: массовая подготовка (650 тыс студентов), изучение ML и AI бизнеса, акселерация 1.5 тыс стартапов с поддержкой экспертов Stanford, Imperial и King\'s College.') ?></p>
			</div>
			<div class="about-image">
				<img src="<?php echo Yii::app()->request->baseUrl; ?>/uploads/aisana.png" alt="<?= Yii::t('labels', 'AI SANA') ?>" />
			</div>
		</div>
	</section>
	
	<section class="container contacts-section" id="contacts-section">
		<h2 class="section-title"><?= Yii::t('labels', 'Контакты') ?></h2>
		<p><?= Yii::t('labels', 'По вопросам сотрудничества и участия в AI Sana пишите') ?></p>
		<div class="social-links center">
			<a href="mailto:gakim@ku.edu.kz?subject=<?= urlencode('Вопрос по сотрудничеству AI Sana') ?>&body=<?= urlencode('Здравствуйте!\n\n') ?>" class="social-link">
				<img src="<?php echo Yii::app()->request->baseUrl; ?>/components/icons/news.png" alt="Email" />
			</a>
		</div>
	</section>
</section>

