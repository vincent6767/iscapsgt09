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
}

function TestSendingDataView(){
	this.appendRecord = function(record) {
		p = document.createElement('p');
		p.innerHTML = "Sent RPM: " + record.rpm + " ; User ID: " + record.user_id + " ; date retrieved: " + record.date_retrieved;
		$('#test-output').prepend(p);
	}
}