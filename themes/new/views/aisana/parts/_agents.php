<section class="agents-section" id="ai-agents-section">
    <div class="container agents-container">
        <h2 class="section-title"><?= Yii::t('labels', 'Наши AI-агенты') ?></h2>

        <?php
        $agents = array(
            array(
                'title' => Yii::t('labels', 'AI AntiFraud'),
                'status' => 'deployed',
                'statusText' => Yii::t('labels', 'ВНЕДРЁН'),
                'description' => Yii::t('labels', 'Поведенческий скоринг для antifraud.'),
                'link' => 'https://aisanasku.streamlit.app/',
                'features' => array(
                    Yii::t('labels', 'Точность ~99%'),
                    Yii::t('labels', 'SHAP, Gini, KS'),
                    Yii::t('labels', 'Ручная проверка ↓70%'),
                    Yii::t('labels', 'Обработка <30 сек')
                )
            ),
            array(
                'title' => Yii::t('labels', 'CheckDoc'),
                'status' => 'deployed',
                'statusText' => Yii::t('labels', 'ВНЕДРЁН'),
                'description' => Yii::t('labels', 'AI‑доктор для диагностики и рекомендаций.'),
                'link' => 'https://checkdoc.streamlit.app/',
                'features' => array(
                    Yii::t('labels', 'Анализ симптомов за 5 минут'),
                    Yii::t('labels', '1000+ пациентов в день'),
                    Yii::t('labels', 'Снижение затрат в 2 раза'),
                    Yii::t('labels', 'Точность до 90%')
                )
            ),
            array(
                'title' => Yii::t('labels', 'УниЭксперт'),
                'status' => 'deployed',
                'statusText' => Yii::t('labels', 'ВНЕДРЁН'),
                'description' => Yii::t('labels', 'AI для поиска нормативных документов.'),
                'link' => 'https://uniexpert.streamlit.app/',
                'features' => array(
                    Yii::t('labels', 'RAG‑архитектура'),
                    Yii::t('labels', 'Экономия времени на 70%'),
                    Yii::t('labels', 'Интеграция с Telegram'),
                    Yii::t('labels', 'Охват 80% сотрудников')
                )
            ),
            array(
                'title' => Yii::t('labels', 'AI для транспорта'),
                'status' => 'deployed',
                'statusText' => Yii::t('labels', 'ВНЕДРЁН'),
                'description' => Yii::t('labels', 'Оптимизация городских маршрутов.'),
                'link' => 'https://t.me/ai_transport_bot',
                'features' => array(
                    Yii::t('labels', 'Анализ GPS‑данных и камер'),
                    Yii::t('labels', 'Топливо ↓10%'),
                    Yii::t('labels', 'Пассажиропоток ↑15%'),
                    Yii::t('labels', 'Маршруты в реальном времени')
                )
            ),
            array(
                'title' => Yii::t('labels', 'Антикоррупционный бот'),
                'status' => 'deployed',
                'statusText' => Yii::t('labels', 'ВНЕДРЁН'),
                'description' => Yii::t('labels', 'Чат‑бот по вопросам коррупции.'),
                'link' => 'https://truechat.ku.edu.kz/',
                'features' => array(
                    Yii::t('labels', 'Уведомления и сценарии'),
                    Yii::t('labels', 'Обратная связь −50%'),
                    Yii::t('labels', 'Вовлечённость ×3'),
                    Yii::t('labels', 'Снижение рисков')
                )
            )
        );
        ?>

        <div class="carousel-wrapper">
            <div class="swiper agents-carousel">
                <div class="swiper-wrapper">
                    <?php foreach ($agents as $index => $agent): ?>
                        <div class="swiper-slide">
                            <div class="agent-card <?php echo 'status-' . $agent['status']; ?>">
                                <div class="agent-status <?php echo 'status-' . $agent['status']; ?>">
                                    <?php echo $agent['statusText']; ?>
                                </div>
                                <h4 class="agent-title"><?php echo CHtml::encode($agent['title']); ?></h4>
                                <p class="agent-description"><?php echo CHtml::encode($agent['description']); ?></p>

                                <ul class="agent-features">
                                    <?php foreach ($agent['features'] as $feature): ?>
                                        <li><?php echo CHtml::encode($feature); ?></li>
                                    <?php endforeach; ?>
                                </ul>

                                <a href="<?php echo CHtml::encode($agent['link']); ?>"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="agent-btn">
                                    <?= Yii::t('labels', 'Перейти к проекту') ?>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <button class="custom-arrow prev agents-nav-prev" type="button" aria-label="<?= Yii::t('labels', 'Предыдущий') ?>">
                <span class="arrow-icon">«</span>
            </button>
            <button class="custom-arrow next agents-nav-next" type="button" aria-label="<?= Yii::t('labels', 'Следующий') ?>">
                <span class="arrow-icon">»</span>
            </button>
        </div>
    </div>
</section>
