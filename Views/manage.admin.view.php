<?php

use CMW\Manager\Lang\LangManager;
use CMW\Manager\Security\SecurityManager;

/* @var CMW\Entity\Calendar\CalendarEntity[] $events */
/* @var CMW\Entity\Calendar\CalendarSettingsEntity $config */

$title = LangManager::translate("calendar.title");
$description = LangManager::translate("calendar.description");
?>

<div class="d-flex flex-wrap justify-content-between">
    <h3><i class="fa-solid fa-calendar-days"></i> <span
            class="m-lg-auto"><?= LangManager::translate("calendar.manage.title"); ?></span></h3>
</div>


<div class="d-flex flex-wrap justify-content-between">
    <div class="buttons">
        <a type="button" data-bs-toggle="modal" data-bs-target="#add" class="btn btn-primary"><?= LangManager::translate("calendar.manage.addButton"); ?></a>
    </div>
    <div class="buttons">
        <a type="button" data-bs-toggle="modal" data-bs-target="#delete" class="btn btn-danger"><?= LangManager::translate("calendar.manage.removeButton"); ?></a>
    </div>
    <div class="buttons">
        <a type="button" data-bs-toggle="modal" data-bs-target="#settings" class="btn btn-primary"><?= LangManager::translate("calendar.manage.settingsButton"); ?></a>
    </div>
</div>

<hr>

<div id='calendar'></div>

<!----MODAL AJOUT---->
<div class="modal fade text-left" id="add" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel160" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title white"><?= LangManager::translate("calendar.manage.addTitle"); ?></h5>
            </div>
            <form method="post">
                <div class="modal-body">
                        <?php (new SecurityManager())->insertHiddenToken() ?>
                        <h6><?= LangManager::translate("calendar.manage.name"); ?> :</h6>
                        <div class="form-group position-relative has-icon-left">
                            <input type="text" class="form-control" name="name" required>
                            <div class="form-control-icon">
                                <i class="fa-solid fa-signature"></i>
                            </div>
                        </div>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <h6><?= LangManager::translate("calendar.manage.start"); ?> :</h6>
                            <div class="form-group position-relative has-icon-left">
                                <input type="datetime-local" class="form-control" name="startDate" required>
                                <div class="form-control-icon">
                                    <i class="fa-regular fa-calendar-plus"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <h6><?= LangManager::translate("calendar.manage.end"); ?> :</h6>
                            <div class="form-group position-relative has-icon-left">
                                <input type="datetime-local" class="form-control" name="endDate" required>
                                <div class="form-control-icon">
                                    <i class="fa-regular fa-calendar-check"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <h6><?= LangManager::translate("calendar.manage.background"); ?> :</h6>
                            <div class="form-group position-relative">
                                <input type="color" value="#3788D8" class="form-control" name="backgroundColor" required>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <h6><?= LangManager::translate("calendar.manage.border"); ?> :</h6>
                            <div class="form-group position-relative">
                                <input type="color" value="#3788D8" class="form-control" name="borderColor" required>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <h6><?= LangManager::translate("calendar.manage.text"); ?> :</h6>
                            <div class="form-group position-relative">
                                <input type="color" value="#FFFFFF" class="form-control" name="textColor" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x"></i>
                        <span class=""><?= LangManager::translate("core.btn.close") ?></span>
                    </button>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary"><?= LangManager::translate("core.btn.add") ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!----MODAL SETTINGS---->
<div class="modal fade text-left" id="settings" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel160" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title white"><?= LangManager::translate("calendar.manage.settingTitle"); ?></h5>
            </div>
            <form action="manage/applySettings" method="post">
                <div class="modal-body">
                    <?php (new SecurityManager())->insertHiddenToken() ?>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="calendar_settings_use_webhook_new_event" name="calendar_settings_use_webhook_new_event" <?= $config->getUseWebhookNewEvent() ? 'checked' : '' ?>>
                        <label class="form-check-label" for="calendar_settings_use_webhook_new_event"><h6>Discord Webhook - <?= LangManager::translate("calendar.manage.newEvent"); ?> :</h6></label>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="url" name="calendar_settings_webhook_new_event" placeholder="https://discord.com/api/webhooks/" value="<?= $config->getWebhookNewEvent() ?>">
                    </div>
                    <h6><?= LangManager::translate("calendar.manage.calendarLanguage"); ?> :</h6>
                    <select class="choices form-select" name="calendar_settings_locale" required>
                            <option value="en" <?= $config->getLocal() === "en" ? "selected" : "" ?>>English</option>
                            <option value="de" <?= $config->getLocal() === "de" ? "selected" : "" ?>>Deutch</option>
                            <option value="fr" <?= $config->getLocal() === "fr" ? "selected" : "" ?>>Français</option>
                            <option value="zh-cn" <?= $config->getLocal() === "zh-cn" ? "selected" : "" ?>>中国人</option>
                    </select>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="calendar_settings_use_nowIndicator" name="calendar_settings_use_nowIndicator" <?= $config->getUseNowIndicator() ? 'checked' : '' ?>>
                        <label class="form-check-label" for="calendar_settings_use_nowIndicator"><h6><?= LangManager::translate("calendar.manage.showIndicator"); ?> <i data-bs-toggle="tooltip" title="<?= LangManager::translate("calendar.manage.showIndicatorTooltip"); ?>" class="fa-sharp fa-solid fa-circle-info"></i></h6></label>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12 col-lg-4">
                            <h6><?= LangManager::translate("calendar.manage.initialView"); ?> :</h6>
                            <select class="form-select" name="calendar_settings_initialView" required>
                                <option value="dayGridMonth" <?= $config->getInitialView() === "dayGridMonth" ? "selected" : "" ?>><?= LangManager::translate("calendar.manage.month"); ?></option>
                                <option value="timeGridWeek" <?= $config->getInitialView() === "timeGridWeek" ? "selected" : "" ?>><?= LangManager::translate("calendar.manage.week"); ?></option>
                                <option value="timeGridDay" <?= $config->getInitialView() === "timeGridDay" ? "selected" : "" ?>><?= LangManager::translate("calendar.manage.day"); ?></option>
                            </select>
                        </div>
                        <div class="col-12 col-lg-4">
                            <h6><?= LangManager::translate("calendar.manage.dayMaxEventRows"); ?> <i data-bs-toggle="tooltip" title="<?= LangManager::translate("calendar.manage.dayMaxEventRowsTooltip"); ?>" class="fa-sharp fa-solid fa-circle-info"></i> :</h6>
                            <div class="form-group position-relative has-icon-left">
                                <input type="number" value="<?= $config->getDayMaxEventRows() ?>" class="form-control" name="calendar_settings_dayMaxEventRows" required>
                                <div class="form-control-icon">
                                    <i class="fa-solid fa-list-ol"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <h6><?= LangManager::translate("calendar.manage.height"); ?> :</h6>
                            <div class="form-group position-relative has-icon-left">
                                <input type="number" value="<?= $config->getHeight() ?>" class="form-control" name="calendar_settings_height" required>
                                <div class="form-control-icon">
                                    <i class="fa-solid fa-arrows-up-down"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x"></i>
                        <span class=""><?= LangManager::translate("core.btn.close") ?></span>
                    </button>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary"><?= LangManager::translate("core.btn.save") ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!----MODAL SUPPRESSION---->
<div class="modal fade text-left" id="delete" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel160" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title white"><?= LangManager::translate("calendar.manage.deleteTitle"); ?></h5>
            </div>
            <form action="manage/delete" method="post">
            <div class="modal-body">
                <?php (new SecurityManager())->insertHiddenToken() ?>
                    <select class="form-select" name="event" required>
                        <?php foreach ($events as $event): ?>
                            <option value="<?= $event->getId() ?>"><?= $event->getName() ." - (". $event->getStartDate() ." - ". $event->getEndDate().")"?></option>
                        <?php endforeach; ?>
                    </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x"></i>
                    <span class=""><?= LangManager::translate("core.btn.close") ?></span>
                </button>
                <div class="text-center">
                    <button type="submit" class="btn btn-danger"><?= LangManager::translate("core.btn.delete") ?></button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>