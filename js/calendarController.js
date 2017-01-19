$(document).ready(function() {
			
			$('#calendar').fullCalendar({
				header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month,agendaWeek,agendaDay,listWeek'
				},
				defaultDate: '2017-05-15',
			navLinks: true, // can click day/week names to navigate views
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			events: [
			{
				title: 'All Day Event',
				start: '2016-12-01'
			},
			{
				title: 'Long Event',
				start: '2016-12-07',
				end: '2016-12-10'
			},
			{
				id: 999,
				title: 'Repeating Event',
				start: '2016-12-09T16:00:00'
			},
			{
				id: 999,
				title: 'Repeating Event',
				start: '2016-12-16T16:00:00'
			},
			{
				title: 'Conference',
				start: '2016-12-11',
				end: '2016-12-13'
			},
			{
				title: 'Meeting',
				start: '2016-12-12T10:30:00',
				end: '2016-12-12T12:30:00'
			},
			{
				title: 'Lunch',
				start: '2016-12-12T12:00:00'
			},
			{
				title: 'Meeting',
				start: '2016-12-12T14:30:00'
			},
			{
				title: 'Happy Hour',
				start: '2016-12-12T17:30:00'
			},
			{
				title: 'Dinner',
				start: '2016-12-12T20:00:00'
			},
			{
				title: 'Birthday Party',
				start: '2016-12-13T07:00:00'
			},
			{
				title: 'Click for Google',
				url: 'http://google.com/',
				start: '2016-12-28'
			},
			{
				title: 'SK Connections',
				url: 'http://www.skconnections.ca',
				start: '2017-05-10',
				end: '2017-05-12'
			},
			{
				title: 'ARMA Spring Workshops',
				url: 'http://www.eventsystempro.com/arma2217',
				start: '2017-05-15',
				end: '2017-05-17'
			},
			{
				title: 'CBS Annual Conference',
				url: 'http://www.cbs-scb.ca',
				start: '2017-05-24',
				end: '2017-05-27'
			},
			{
				title: 'Maritime Connections Workshops',
				url: 'http://www.maritimeconnections.ca',
				start: '2017-06-13',
				end: '2017-06-15'
			},
			{
				title: 'Staff of Elected Officials Bootcamp',
				url: 'http://www.seobootcamp.ca',
				start: '2017-06-01',
				end: '2017-07-01'
			}
			]
		});
			
		});