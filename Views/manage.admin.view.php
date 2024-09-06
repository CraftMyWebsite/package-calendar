<?php

use CMW\Manager\Lang\LangManager;
use CMW\Manager\Security\SecurityManager;

/* @var CMW\Entity\Calendar\CalendarEntity[] $events */
/* @var CMW\Entity\Calendar\CalendarSettingsEntity $config */

$title = LangManager::translate('calendar.title');
$description = LangManager::translate('calendar.description');
?>

<section class="page-title">
    <h3><i class="fa-solid fa-calendar-days"></i> <?= LangManager::translate('calendar.manage.title'); ?></h3>
    <div class="flex justify-between space-x-2">
        <button data-modal-toggle="modal-add" class="btn-primary" type="button"><?= LangManager::translate('calendar.manage.addButton'); ?></button>
        <button data-modal-toggle="modal-remove" class="btn-danger" type="button"><?= LangManager::translate('calendar.manage.removeButton'); ?></button>
        <button data-modal-toggle="modal-settings" class="btn-primary" type="button"><?= LangManager::translate('calendar.manage.settingsButton'); ?></button>
    </div>
</section>

<hr>

<div id='calendar'></div>

<div id="modal-add" class="modal-container">
    <div class="modal">
        <div class="modal-header">
            <h6><?= LangManager::translate('calendar.manage.addTitle'); ?></h6>
            <button type="button" data-modal-hide="modal-add"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form method="post">
            <?php (new SecurityManager())->insertHiddenToken() ?>
        <div class="modal-body">
            <label for="name"><?= LangManager::translate('calendar.manage.name'); ?> :</label>
            <div class="input-group">
                <i class="fa-solid fa-signature"></i>
                <input type="text" id="name" name="name" required>
            </div>
            <label for="startDate"><?= LangManager::translate('calendar.manage.start'); ?> :</label>
            <div class="input-group">
                <i class="fa-regular fa-calendar-plus"></i>
                <input type="datetime-local" id="startDate" name="startDate" required>
            </div>
            <label for="endDate"><?= LangManager::translate('calendar.manage.end'); ?> :</label>
            <div class="input-group">
                <i class="fa-regular fa-calendar-check"></i>
                <input type="datetime-local" id="endDate" name="endDate" required>
            </div>
            <div class="grid-3">
                <div>
                    <label for="backgroundColor"><?= LangManager::translate('calendar.manage.background'); ?> :</label>
                    <input type="color" value="#3788D8" class="form-control" id="backgroundColor" name="backgroundColor" required>
                </div>
                <div>
                    <label for="borderColor"><?= LangManager::translate('calendar.manage.border'); ?> :</label>
                    <input type="color" value="#3788D8" class="form-control" id="borderColor" name="borderColor" required>
                </div>
                <div>
                    <label for="textColor"><?= LangManager::translate('calendar.manage.text'); ?> :</label>
                    <input type="color" value="#FFFFFF" class="form-control" id="textColor" name="textColor" required>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn-danger"><?= LangManager::translate('core.btn.add') ?></button>
        </div>
        </form>
    </div>
</div>

<div id="modal-settings" class="modal-container">
    <div class="modal">
        <div class="modal-header">
            <h6><?= LangManager::translate('calendar.manage.settingTitle'); ?></h6>
            <button type="button" data-modal-hide="modal-settings"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form action="manage/applySettings" method="post">
            <?php (new SecurityManager())->insertHiddenToken() ?>
        <div class="modal-body">
            <div>
                <label class="toggle">
                    <p class="toggle-label">Discord Webhook - <?= LangManager::translate('calendar.manage.newEvent'); ?> :</p>
                    <input type="checkbox" class="toggle-input" id="calendar_settings_use_webhook_new_event" name="calendar_settings_use_webhook_new_event" <?= $config->getUseWebhookNewEvent() ? 'checked' : '' ?>>
                    <div class="toggle-slider"></div>
                </label>
            </div>
            <input type="url" id="calendar_settings_webhook_new_event" class="input" name="calendar_settings_webhook_new_event" placeholder="https://discord.com/api/webhooks/" value="<?= $config->getWebhookNewEvent() ?>">
            <label for="calendar_settings_locale"><?= LangManager::translate('calendar.manage.calendarLanguage'); ?> :</label>
            <select id="calendar_settings_locale" name="calendar_settings_locale" required>
                <option value="en" <?= $config->getLocal() === 'en' ? 'selected' : '' ?>>English</option>
                <option value="de" <?= $config->getLocal() === 'de' ? 'selected' : '' ?>>Deutch</option>
                <option value="fr" <?= $config->getLocal() === 'fr' ? 'selected' : '' ?>>Français</option>
                <option value="zh-cn" <?= $config->getLocal() === 'zh-cn' ? 'selected' : '' ?>>中国人</option>
            </select>
            <div>
                <label class="toggle">
                    <p class="toggle-label"><?= LangManager::translate('calendar.manage.showIndicator'); ?> <i data-bs-toggle="tooltip" title="<?= LangManager::translate('calendar.manage.showIndicatorTooltip'); ?>" class="fa-sharp fa-solid fa-circle-info"></i></p>
                    <input type="checkbox" class="toggle-input" id="calendar_settings_use_nowIndicator" name="calendar_settings_use_nowIndicator" <?= $config->getUseNowIndicator() ? 'checked' : '' ?>>
                    <div class="toggle-slider"></div>
                </label>
            </div>
            <label for="calendar_settings_initialView"><?= LangManager::translate('calendar.manage.initialView'); ?> :</label>
            <select id="calendar_settings_initialView" name="calendar_settings_initialView" required>
                <option value="dayGridMonth" <?= $config->getInitialView() === 'dayGridMonth' ? 'selected' : '' ?>><?= LangManager::translate('calendar.manage.month'); ?></option>
                <option value="timeGridWeek" <?= $config->getInitialView() === 'timeGridWeek' ? 'selected' : '' ?>><?= LangManager::translate('calendar.manage.week'); ?></option>
                <option value="timeGridDay" <?= $config->getInitialView() === 'timeGridDay' ? 'selected' : '' ?>><?= LangManager::translate('calendar.manage.day'); ?></option>
            </select>
            <div class="grid-2">
                <div>
                    <label for="calendar_settings_dayMaxEventRows"><?= LangManager::translate('calendar.manage.dayMaxEventRows'); ?> <i data-bs-toggle="tooltip" title="<?= LangManager::translate('calendar.manage.dayMaxEventRowsTooltip'); ?>" class="fa-sharp fa-solid fa-circle-info"></i> :</label>
                    <div class="input-group">
                        <i class="fa-solid fa-list-ol"></i>
                        <input type="number" id="calendar_settings_dayMaxEventRows" value="<?= $config->getDayMaxEventRows() ?>" name="calendar_settings_dayMaxEventRows" required>
                    </div>
                </div>
                <div>
                    <label for="calendar_settings_height"><?= LangManager::translate('calendar.manage.height'); ?> :</label>
                    <div class="input-group">
                        <i class="fa-solid fa-arrows-up-down"></i>
                        <input type="number" id="calendar_settings_height" value="<?= $config->getHeight() ?>" name="calendar_settings_height" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn-danger"><?= LangManager::translate('core.btn.save') ?></button>
        </div>
        </form>
    </div>
</div>

<div id="modal-remove" class="modal-container">
    <div class="modal">
        <div class="modal-header-danger">
            <h6><?= LangManager::translate('calendar.manage.deleteTitle'); ?></h6>
            <button type="button" data-modal-hide="modal-remove"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form action="manage/delete" method="post">
            <?php (new SecurityManager())->insertHiddenToken() ?>
        <div class="modal-body">
            <select name="event" required>
                <?php foreach ($events as $event): ?>
                    <option value="<?= $event->getId() ?>"><?= $event->getName() . ' - (' . $event->getStartDate() . ' - ' . $event->getEndDate() . ')' ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn-danger"><?= LangManager::translate('core.btn.delete') ?></button>
        </div>
        </form>
    </div>
</div>