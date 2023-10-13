<?php

use CMW\Manager\Lang\LangManager;
use CMW\Manager\Security\SecurityManager;

$title = "Calendrier";
$description = "Gérez les événements du calendrier";
?>

<div class="d-flex flex-wrap justify-content-between">
    <h3><i class="fa-solid fa-calendar-days"></i> <span
            class="m-lg-auto">Gestion du calendrier</span></h3>
</div>

<form method="post">
    <?php (new SecurityManager())->insertHiddenToken() ?>
    <input type="text" name="name" placeholder="Titre de l'événement" required>
    start :
    <input type="datetime-local" name="startDate" required>
    end :
    <input type="datetime-local" name="endDate" required>
    <input type="submit" value="Ajouter événement">
</form>

<script>

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'fr',
            height: 650,
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay' // user can switch between the two
            },
            events: <?= \CMW\Model\Calendar\CalendarModel::getInstance()->getJsonEvents() ?>
        });
        calendar.render();
    });

</script>

<div style="max-width: 95%" id='calendar'></div>