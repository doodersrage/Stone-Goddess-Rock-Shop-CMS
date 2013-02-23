
    //<![CDATA[

    function load() {
      if (GBrowserIsCompatible()) {
      	
		// A TextualZoomControl is a GControl that displays textual "Zoom In"
// and "Zoom Out" buttons (as opposed to the iconic buttons used in
// Google Maps).
function TextualZoomControl() {
}
TextualZoomControl.prototype = new GControl();

// Creates a one DIV for each of the buttons and places them in a container
// DIV which is returned as our control element. We add the control to
// to the map container and return the element for the map class to
// position properly.
TextualZoomControl.prototype.initialize = function(map) {
  var container = document.createElement("div");

  map.getContainer().appendChild(container);
  return container;
}

// By default, the control will appear in the top left corner of the
// map with 7 pixels of padding.
TextualZoomControl.prototype.getDefaultPosition = function() {
  return new GControlPosition(G_ANCHOR_TOP_LEFT, new GSize(7, 7));
}

		var map = new GMap2(document.getElementById("map"));
		map.addControl(new GSmallMapControl());
		map.addControl(new GMapTypeControl());
		map.addControl(new TextualZoomControl());
        map.setCenter(new GLatLng(37.389007, -77.426229), 13);
		var point = new GPoint(parseFloat(-77.426229),parseFloat(37.389007));
        var marker = new GMarker(point);
		map.addOverlay(marker);
		

// Our info window content
var infoTabs = [
  new GInfoWindowTab("Address", "Stone Goddess Rock Shop<br />10017 Jefferson Davis Hwy.<br /> Richmond Va. 23237<br /> I-95  exit 62, Route 288 to 301 North 1/2 Mile"),
  new GInfoWindowTab("Hours","Monday and Tuesday Closed<br />Wednesday Through Friday 10 AM TO 5:30PM<br />Saturday	10 AM TO 5 PM<br />Sunday 1 PM TO 5 PM")
];

// Place a marker in the center of the map and open the info window
// automatically
var marker = new GMarker(map.getCenter());
GEvent.addListener(marker, "click", function() {
  marker.openInfoWindowTabsHtml(infoTabs);
});
map.addOverlay(marker);
marker.openInfoWindowTabsHtml(infoTabs);
	  }
    }

    //]]>

