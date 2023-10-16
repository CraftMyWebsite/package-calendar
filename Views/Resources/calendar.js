const xhr = new XMLHttpRequest();
xhr.open('GET', '/api/calendar/data', true);

xhr.onload = function () {
    if (xhr.status === 200) {
        const response = xhr.responseText;
        try {
            const data = JSON.parse(response);
            const events = JSON.parse(data.events);
            const settingsObj = JSON.parse(data.settings);
            const locale = settingsObj[0].locale;
            const dayMaxEventRows = settingsObj[0].dayMaxEventRows;
            const useNowIndicator = settingsObj[0].useNowIndicator;
            const height = settingsObj[0].height;
            const initialView = settingsObj[0].initialView;

            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                locale: locale,
                dayMaxEventRows: dayMaxEventRows,
                height: height,
                nowIndicator: useNowIndicator,
                now: new Date(),
                initialView: initialView,
                headerToolbar: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: events
            });
            calendar.render();
            console.log(useNowIndicator)

        } catch (error) {
            console.error('Erreur lors de la conversion de la réponse en JSON:', error);
        }
    } else {
        console.error('Erreur de chargement: Statut ' + xhr.status);
    }
};

xhr.send();