<?php
$this->pageTitle = Yii::t('labels', 'Админ-панель');
Yii::app()->clientScript->registerCssFile(
	Yii::app()->baseUrl . '/css/admin.css?v=1.0',
	'screen',
	CClientScript::POS_HEAD
);
Yii::app()->clientScript->registerCssFile(
	Yii::app()->baseUrl . '/css/admin.css?v=1.0',
	'screen',
	CClientScript::POS_HEAD
);
?>

<div class="admin-dashboard">
	<div class="admin-header">
		<h1 class="admin-title"><?= Yii::t('labels', 'Админ-панель') ?></h1>
		<div class="admin-user-info">
			<span class="admin-username"><?= CHtml::encode(Yii::app()->user->name ?: Yii::app()->user->getState('username')) ?></span>
			<?php echo CHtml::link(
				Yii::t('labels', 'Выйти'),
				array('admin/logout'),
				array('class' => 'admin-logout-btn')
			); ?>
		</div>
	</div>

	<div class="admin-stats">
		<div class="admin-stat-card">
			<div class="admin-stat-icon">👥</div>
			<div class="admin-stat-content">
				<div class="admin-stat-value"><?= $stats['totalUsers'] ?></div>
				<div class="admin-stat-label"><?= Yii::t('labels', 'Пользователей') ?></div>
			</div>
		</div>

		<div class="admin-stat-card">
			<div class="admin-stat-icon">📰</div>
			<div class="admin-stat-content">
				<div class="admin-stat-value"><?= $stats['totalNews'] ?></div>
				<div class="admin-stat-label"><?= Yii::t('labels', 'Новостей') ?></div>
			</div>
		</div>

		<div class="admin-stat-card">
			<div class="admin-stat-icon">📚</div>
			<div class="admin-stat-content">
				<div class="admin-stat-value"><?= $stats['totalCourses'] ?></div>
				<div class="admin-stat-label"><?= Yii::t('labels', 'Курсов') ?></div>
			</div>
		</div>

		<div class="admin-stat-card">
			<div class="admin-stat-icon">🚀</div>
			<div class="admin-stat-content">
				<div class="admin-stat-value"><?= $stats['totalProjects'] ?></div>
				<div class="admin-stat-label"><?= Yii::t('labels', 'Проектов') ?></div>
			</div>
		</div>
	</div>

	<div class="admin-actions">
		<h2 class="admin-section-title"><?= Yii::t('labels', 'Быстрые действия') ?></h2>
		<div class="admin-action-buttons">
			<a href="<?= Yii::app()->createUrl('admin/newsIndex') ?>" class="admin-action-btn admin-action-btn-primary">
				<?= Yii::t('labels', 'Управление новостями') ?>
			</a>
			<a href="<?= Yii::app()->createUrl('admin/coursesIndex') ?>" class="admin-action-btn admin-action-btn-primary">
				<?= Yii::t('labels', 'Управление курсами') ?>
			</a>
			<a href="<?= Yii::app()->createUrl('admin/projectsIndex') ?>" class="admin-action-btn admin-action-btn-primary">
				<?= Yii::t('labels', 'Управление проектами') ?>
			</a>
			<a href="<?= Yii::app()->createUrl('aisana/index') ?>" class="admin-action-btn">
				<?= Yii::t('labels', 'Главная страница') ?>
			</a>
			<a href="<?= Yii::app()->createUrl('admin/logout') ?>" class="admin-action-btn admin-action-btn-danger">
				<?= Yii::t('labels', 'Выйти') ?>
			</a>
		</div>
	</div>
</div>

