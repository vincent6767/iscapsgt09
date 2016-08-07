function TestingCyclingController(view) {
	this.view = view;
	this.startPolling = function(url, delay) {
		that = this;
		setTimeout(function() {
					$.get(url, function(data) {
						data = JSON.parse(data);

						view.appendRecord(data);
						that.startPolling(url, delay);
					});
				}, delay);
	}
	this.posting = function(url, delay) {
		self = this;
		setTimeout(function() {
			var randNumber = Math.random() * 100;
			var cycling = {
				'user_id': 4,
				'rpm': randNumber
			};
			console.log(JSON.stringify(cycling));
			$.ajax({
				url: url,
				type: 'POST',
				contentType: 'application/json; charset=utf-8',
				dataType: 'json',
				data: JSON.stringify(cycling)
			});
			self.posting(url, delay);
		}, delay);
	}
}

function TestSendingDataView(){
	this.appendRecord = function(record) {
		p = document.createElement('p');
		p.innerHTML = "Sent RPM: " + record.rpm + " ; User ID: " + record.user_id + " ; date retrieved: " + record.date_retrieved;
		$('#test-output').prepend(p);
	}
}

function CyclingSession(id, startTime) {
	this.id = id;
	this.startTime = startTime;
	this.finishTime = null;
	this.calories = 0;

	this.updateCalories = function(calories) {
		this.calories = calories;
	}
	this.getCalories = function() {
		return this.calories;
	}
	this.getWorkDuration = function(unit = 'ms') {
		finishTime = (this.finishTime) ? new Date(this.finishTime) : new Date();

		startTime = new Date(this.startTime);

		ms = finishTime - startTime;

		unit = unit.toLowerCase();

		if (unit == 'ms') {
			return ms;
		} else if (unit == 's') {
			return ms / 1000;
		} else if (unit == 'm') {
			return ms / (1000 * 60);
		} else if (unit == 'h') {
			return ms / (1000 * 60 * 60);
		} else if (unit == 'd') {
			return ms / (1000 * 60 * 60 * 24);
		}

	}
	/*this.createDate = function(time) {
		//2016-06-06  1 0 : 1 0 : 1 0
		//0123456789101112131415161718
		year = time.substr(0, 4);
		month = time.substr(5, 2);
		day = time.substr(8,2);
		hour = time.substr(11,2);
		minute = time.substr(14, 2);
		second = time.substr(17,2);

		return new Date(time);
	}*/
}

function CaloriesCalculator(user) {
	this.user = user;

	this.calculateCalories = function() {
		workDuration = this.user.getCurrentSession().getWorkDuration('s');

		if (this.user.is('m')) {
			return ((0.2017 * this.user.getAge()) - (0.19921 * this.user.getWeight()) + 0.37854 * (220 - this.user.getAge()) - 55.0969) * (workDuration / (60 * 4.184));
		} else if (this.user.is('f')) {
			return ((0.074 * this.user.getAge()) - (0.126567 * this.user.getWeight()) + 0.26832 * (220 - this.user.getAge()) - 20.4022) * (workDuration / (60 * 4.184));
		}
	}
}

function User(age, weight, points, gender, session) {
	this.age = age;
	this.weight = weight;
	this.points = points;
	this.gender = gender;
	this.session = session;
	this.errors = [];

	this.isValid = function() {
		result = true;

		if (!this.age) {
			result = false;
			message = {'age': 'Age is field is required'};
			this.addMessage(message);
		} 
		if (!this.weight) {
			result = false;
			message = {'weight': 'Weight is field is required'};
			this.addMessage(message);
		} 
		if (!this.gender) {
			result = false;
			message = {'gender': 'Gender is field is required'};
			this.addMessage(message);
		}
		return result;
	}

	this.addMessage = function(message) {
		this.errors.push(message);
	}

	this.getErrors = function() {
		return this.errors;
	}
	this.is = function(gender) {
		return (this.gender == gender.toLowerCase());
	}
	this.getAge = function() {
		return this.age;
	}
	this.getWeight = function() {
		return this.weight;
	}
	this.getGender = function() {
		return this.gender;
	}
	this.getPoints = function() {
		return this.points;
	}
	this.getCurrentSession = function() {
		return this.session;
	}
}

function UserInformationView(speedometer) {
	this.suffixError = '-error';
	this.speedometer = speedometer;
	this.onChangeList = ['age', 'weight', 'gender'];
	/*
		Initialize all behaviours related to User Information Page
		@params controller UserInformationController
		@return void
	*/
	this.initialize = function(controller) {
		var self = this;
		self.onChangeList.forEach(function(name) {
			self.assignInputEvent('change', name, function() {
				controller.update(name, self.getInput(name));
			});
		});
		
		window.onbeforeunload = function() {
			controller.stopSession();
		}
		window.onunload = function() {
			controller.stopSession();
		}
	}
	this.assignInputEvent = function(eventName, elemName, callback) {
		$('input[name=' + elemName + ']').on(eventName, callback);
	}
	this.getInput = function(name) {
		inputType = $('input[name=' + name + ']').first().attr('type');

		if (inputType == 'radio') {
			return $('input[name=' + name + ']:checked').val();
		} else {
			return $('input[name=' + name + ']').first().val();
		}
	}
	this.setInput = function(name, value) {
		$('input[name=' + name + ']').first().val(value);
	}
	this.displayErrors = function(messages) {
		var self = this;
		messages.forEach(function(message) {
			for (var prop in message) {
				if (message.hasOwnProperty(prop)) {
					$('#' + prop + self.suffixError).html('<strong>' + message[prop] + '</strong>')
				}
			}
		});
	}
	this.updateSpeedometer = function(rpm) {
		this.speedometer.series[0].points[0].update(parseInt(rpm));
	}
	this.updatePoints = function(points) {
		this.setInput('points', points);
	}
	this.updateCalories = function(calories) {
		this.setInput('calories', calories);
	}
	this.clearErrors = function() {
		var self = this;

		self.onChangeList.forEach(function(name) {
			$('#' + name + self.suffixError).empty();
		});
	}
}

function UserInformationController(view, user, cCalculator, onUnloadGoTo = '') {
	this.view = view;
	this.model = user;
	this.cCalculator = cCalculator;
	this.onUnloadGoTo = onUnloadGoTo;

	this.initialize = function() {
		this.view.initialize(this);
	}

	this.update = function(propName, value) {
		this.model[propName] = value;
	}
	this.stopSession = function() {
		console.log('Post sessions data....');
		var session = JSON.stringify(this.model.getCurrentSession());

			$.ajax({
				type: 'POST',
				async: false,
				url: this.onUnloadGoTo,
				data: session,
				dataType: "json",
				contentType: "application/json; charset=utf-8"
			});		

		console.log('Finish posting data!');
	}

	this.polling = function(url, delay) {
		var self = this;
		setTimeout(function() {
			self.view.clearErrors();

			if (!self.model.isValid()) {
				self.view.displayErrors(self.model.getErrors());
				console.log('Wait User to fix the value...');
			} else {
				$.get(url, function(data) {
					data = JSON.parse(data);

					session = self.model.getCurrentSession();

					session.finishTime = data.timestamps;

					session.updateCalories(self.cCalculator.calculateCalories());
					//console.log(self.model.getCurrentSession().calories);

					self.view.updateSpeedometer(data.rpm);
					self.view.updatePoints(data.points);
					self.view.updateCalories(session.getCalories());
				});
			}

			self.polling(url, delay);
		}, delay);
	}
}