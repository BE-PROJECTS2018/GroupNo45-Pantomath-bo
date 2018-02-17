// Generate a graph
var graph = new Rickshaw.Graph( {
	element: document.getElementById("chart"),
	width: 600,
	height: 240,
	renderer: 'line',
	series: new Rickshaw.Series.Sliding([{ name: 'mySeries'}], undefined, {
		maxDataPoints: 100,
	})
} );

// Render the graph
graph.render();

// Create a new EventSource
var evtSrc = new EventSource("/stream");

// Handle receiving data
var count = 0;
evtSrc.onmessage = function(e) {
	var obj = JSON.parse(e.data);
	// New data is entered as ({seriesKey: yval, ...}, xval)
	graph.series.addData(obj.series, obj.x);
	graph.render();
	count += 1;
};

// Would be possible to attach event handlers to do things like modify graphs...