<?php
/* @var $this ChatAdminController */
/* @var $totalSessions integer */
/* @var $uniqueSessions integer */
/* @var $days integer */
/* @var $popularAnswers array */
/* @var $unmatchedQueries ChatUnmatchedQuery[] */

$this->breadcrumbs=array(
	'Чат-бот' => array('index'),
	'Статистика',
);

$this->menu=array(
	array('label'=>'Управление категориями', 'url'=>array('categoryIndex')),
	array('label'=>'Управление ответами', 'url'=>array('answerIndex')),
	array('label'=>'Статистика', 'url'=>array('stats'), 'active'=>true),
);
?>

<h1>Статистика чат-бота</h1>

<div class="row">
	<div class="span6">
		<h2>Общая статистика</h2>
		<table class="table table-bordered">
			<tr>
				<td><strong>Всего сессий:</strong></td>
				<td><?php echo $totalSessions; ?></td>
			</tr>
			<tr>
				<td><strong>Уникальных сессий за <?php echo $days; ?> дней:</strong></td>
				<td><?php echo $uniqueSessions; ?></td>
			</tr>
		</table>
		
		<form method="get" class="form-inline">
			<label>Период:</label>
			<select name="days">
				<option value="7" <?php echo $days == 7 ? 'selected' : ''; ?>>7 дней</option>
				<option value="30" <?php echo $days == 30 ? 'selected' : ''; ?>>30 дней</option>
				<option value="90" <?php echo $days == 90 ? 'selected' : ''; ?>>90 дней</option>
			</select>
			<button type="submit" class="btn">Применить</button>
		</form>
	</div>
</div>

<div class="row" style="margin-top: 20px;">
	<div class="span12">
		<h2>Популярные ответы</h2>
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>ID</th>
					<th>Категория</th>
					<th>Название</th>
					<th>Количество запросов</th>
				</tr>
			</thead>
			<tbody>
				<?php if(empty($popularAnswers)): ?>
					<tr><td colspan="4">Нет данных</td></tr>
				<?php else: ?>
					<?php foreach($popularAnswers as $answer): ?>
						<tr>
							<td><?php echo $answer['id']; ?></td>
							<td><?php echo CHtml::encode($answer['category_title']); ?></td>
							<td><?php echo CHtml::link(CHtml::encode($answer['title']), array('answerView', 'id'=>$answer['id'])); ?></td>
							<td><?php echo $answer['request_count']; ?></td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>

<div class="row" style="margin-top: 20px;">
	<div class="span12">
		<h2>Непонятые запросы (последние 50)</h2>
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>ID</th>
					<th>Текст запроса</th>
					<th>Дата</th>
				</tr>
			</thead>
			<tbody>
				<?php if(empty($unmatchedQueries)): ?>
					<tr><td colspan="3">Нет данных</td></tr>
				<?php else: ?>
					<?php foreach($unmatchedQueries as $query): ?>
						<tr>
							<td><?php echo $query->id; ?></td>
							<td><?php echo CHtml::encode($query->query_text); ?></td>
							<td><?php echo $query->created_at; ?></td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>

