<?php

$_lang['scheduler'] = "Планировщик";
$_lang['scheduler.menu_desc'] = "Фоновые задания: просмотр и запуск";
$_lang['scheduler.search...'] = "Поиск...";
$_lang['scheduler.filter_task'] = "Фильтр по заданиям";
$_lang['scheduler.filter_type...'] = "Фильтр по типу";
$_lang['scheduler.filter_namespace...'] = "Фильтр по категории";
$_lang['scheduler.search_clear'] = "Сбросить фильтр";

$_lang['scheduler.tbar.queued'] = "Запланировано";
$_lang['scheduler.tbar.pastdue'] = "Просрочено";
$_lang['scheduler.tbar.running'] = "Выполняется";
$_lang['scheduler.tbar.completed'] = "Завершено";

$_lang['scheduler.upcoming'] = "Предстоящие задания";
$_lang['scheduler.future'] = "Запланированные запуски";
$_lang['scheduler.history'] = "Прошедшие запуски";

$_lang['scheduler.tasks_desc'] = "Показать задания, которые можно запланировать.";
$_lang['scheduler.future_desc'] = "Список задания для ближайшего запуска.";
$_lang['scheduler.history_desc'] = "Список завершенных заданий, которые были запущены в прошлом.";

$_lang['scheduler.class_key'] = "Тип задания";
$_lang['scheduler.content'] = "Содержимое";
$_lang['scheduler.content.file'] = "Путь к файлу";
$_lang['scheduler.content.file_desc'] = "Введите путь к файлу, который нужно запустить. Путь должен быть относительно core для выбранной категории (namespace).";
$_lang['scheduler.content.snippet'] = "Выбор сниппета";
$_lang['scheduler.content.snippet_desc'] = "Выберите сниппет из списка. Он будет выполнен при запуске задания.";
$_lang['scheduler.content.processor'] = "Название процессора";
$_lang['scheduler.content.processor_desc'] = "Введите название процессора, который будет выполнен при каждом запуске. Относительно папки процессора выбранной категории (namespace) и без расширения (.class).php.";
$_lang['scheduler.namespace'] = "Пространство имен";
$_lang['scheduler.reference'] = "Название";
$_lang['scheduler.task_key'] = "Признак (key)";
$_lang['scheduler.description'] = "Описание задания";
$_lang['scheduler.status'] = "Статус";
$_lang['scheduler.task'] = "Задание";
$_lang['scheduler.tasks'] = "Задания";
$_lang['scheduler.timing'] = "Планируемое время запуска";
$_lang['scheduler.timing.inabout'] = "Примерно через";
$_lang['scheduler.timing.desc'] = "Важно: если явно указать планируемое время запуска, настройка «Примерно через» игнорируется!";
$_lang['scheduler.data'] = "Данные";
$_lang['scheduler.errors'] = "Ошибки";
$_lang['scheduler.message'] = "Сообщения";
$_lang['scheduler.next_run'] = "Следующий запуск";
$_lang['scheduler.runs'] = "Запуски";
$_lang['scheduler.executedon'] = "Запущено";
$_lang['scheduler.processing_time'] = "Время работы";
$_lang['scheduler.avg_processing_time'] = "Среднее время работы";
$_lang['scheduler.actions'] = "Действия";

$_lang['scheduler.task_create'] = "Создать задание";
$_lang['scheduler.task_update'] = "Обновить задание";
$_lang['scheduler.task_remove'] = "Удалить задание";
$_lang['scheduler.task_remove_confirm'] = "Вы уверены, что хотите удалить задание «[[+reference]]»?";

$_lang['scheduler.run_create'] = "Запланировать запуск";
$_lang['scheduler.run_update'] = "Обновить  запуск";
$_lang['scheduler.run_remove'] = "Удалить  запуск";
$_lang['scheduler.runs_remove'] = "Удалить  запуски";
$_lang['scheduler.run_remove_confirm'] = "Вы уверены, что хотите удалить этот  запуск?";
$_lang['scheduler.run_multiple_remove_confirm'] = "Вы уверены, что хотите удалить эти запуски?";

$_lang['scheduler.data.add'] = "Добавить параметр";
$_lang['scheduler.data.key'] = "Имя параметра";
$_lang['scheduler.data.value'] = "Значение параметра";
$_lang['scheduler.data.update'] = "Обновить параметр";
$_lang['scheduler.data.remove'] = "Удалить параметр";
$_lang['scheduler.data.remove_confirm'] = "Вы уверены, что хотите удалить этот параметр?";

$_lang['scheduler.status_0'] = "Ожидает";
$_lang['scheduler.status_1'] = "Выполняется";
$_lang['scheduler.status_2'] = "Успешно";
$_lang['scheduler.status_3'] = "Провалено";

$_lang['scheduler.class.sFileTask'] = "На основе файла";
$_lang['scheduler.class.sSnippetTask'] = "На основе сниппета";
$_lang['scheduler.class.sProcessorTask'] = "На основе процессора";

$_lang['scheduler.time.m'] = "мин.";
$_lang['scheduler.time.h'] = "ч.";
$_lang['scheduler.time.d'] = "дн.";
$_lang['scheduler.time.mnt'] = "мес.";
$_lang['scheduler.time.y'] = "лет";

$_lang['scheduler.reschedule'] = "Запланировать снова";

$_lang['scheduler.error.noresults'] = "Записей не найдено.";
$_lang['scheduler.error.no-file-content'] = "Нужно указать путь к файлу для запуска задания.";
$_lang['scheduler.error.no-snippet-content'] = "Нужно выбрать сниппет для запуска задания.";
$_lang['scheduler.error.no-processor-content'] = "Нужно указать название процессора для задания.";
$_lang['scheduler.error.no-timing'] = "Нужно указать время запуска для задания.";

// Циклические задания
$_lang['scheduler.recurring'] = 'Циклическое';
$_lang['scheduler.recurring_desc'] = 'Включите для автоматического перепланирования задания после каждого успешного выполнения';
$_lang['scheduler.interval'] = 'Интервал';
$_lang['scheduler.interval_desc'] = 'Интервал между запусками в формате strtotime (например, "+30 minutes", "+1 hour", "+1 day")';

$_lang['scheduler.error.no-interval'] = 'Укажите интервал для циклического задания.';
$_lang['scheduler.error.invalid-interval'] = 'Неверный формат интервала. Используйте формат strtotime, например "+30 minutes" или "+1 hour".';

$_lang['setting_scheduler.email_failure'] = "Адреса Email для уведомлений";
$_lang['setting_scheduler.email_failure_desc'] = "Введите адрес, или несколько, через запятую, для отправки уведомлений о проваленных заданиях.";
$_lang['setting_scheduler.email_failure_tpl'] = "Чанк шаблона письма об ошибке";
$_lang['setting_scheduler.email_failure_tpl_desc'] = "Имя чанка для писем об ошибках. Оставьте пустым для встроенного шаблона. Доступные плейсхолдеры: [[+task_namespace]], [[+task_reference]], [[+run_id]], [[+run_message]], [[+run_errors_formatted]], [[+site_name]], [[+executed_on]], [[+run_retry_count]].";
$_lang['setting_scheduler.email_failure_subject'] = "Тема письма об ошибке";
$_lang['setting_scheduler.email_failure_subject_desc'] = "Своя тема для писем об ошибках. Оставьте пустым для темы по умолчанию. Поддерживает плейсхолдеры: [[+task_namespace]], [[+task_reference]], [[+site_name]].";
$_lang['setting_scheduler.delete_tasks_after'] = "Удалять записи о старых запусках после";
$_lang['setting_scheduler.delete_tasks_after_desc'] = 'Укажите strtotime() — совместимую строку (например "-1 year" или "-2 weeks") для автоматического удаления выполненных и проваленных заданий старше, чем указанный временной отрезок. Очистка запускается автоматически раз в 30 минут через cron-задание run.php.';
$_lang['setting_scheduler.recurring_on_failure'] = 'Продолжать цикл при ошибке';
$_lang['setting_scheduler.recurring_on_failure_desc'] = 'Если включено, циклические задания будут продолжать планироваться даже после неудачного выполнения. По умолчанию: выключено (останавливается при ошибке).';

$_lang['area_recurring'] = 'Циклические задания';
$_lang['setting_scheduler.tasks_per_run'] = "Заданий за один запуск";
$_lang['setting_scheduler.tasks_per_run_desc'] = "Максимальное количество заданий за один запуск cron. По умолчанию 1. Увеличьте для большей пропускной способности, но учитывайте возможные таймауты.";

$_lang['scheduler.max_retries'] = "Макс. повторов";
$_lang['scheduler.max_retries_desc'] = "Максимальное количество повторных попыток при неудаче. Установите 0 для отключения повторов.";
$_lang['scheduler.retry_delay'] = "Задержка повтора (сек)";
$_lang['scheduler.retry_delay_desc'] = "Задержка в секундах перед повторной попыткой. По умолчанию 60 секунд.";
$_lang['scheduler.retry_count'] = "Попытка повтора";
