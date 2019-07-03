<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <style type="text/css">
      html { height: 100% }
      body { height: 100%; margin: 0; padding: 0 }
      #map-canvas { height: 100% }
    </style>
    <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBd2vGfImkg3ljpZ7CT_l8Xr1KKkwDbSBM&sensor=true">
    </script>
    <script type="text/javascript">

	function initialize() {
	  var myLatlng = new google.maps.LatLng(<?php echo $lat; ?>, <?php echo $long; ?>); //-7.98130241, 112.61628165
	  var mapOptions = {
		zoom: 17,
		center: myLatlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	  };

	  var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

	  var contentString = 'Lokasi Realisasi';

	  var infowindow = new google.maps.InfoWindow({
		  content: contentString
	  });

	  var marker = new google.maps.Marker({
		  position: myLatlng,
		  map: map,
		  title: 'Lokasi Realisasi'
	  });
	  google.maps.event.addListener(marker, 'click', function() {
		infowindow.open(map,marker);
	  });
	}

	google.maps.event.addDomListener(window, 'load', initialize);
	
	
	</script>
  </head>
  <body>
    <div id="map-canvas"></div>
  </body>
</html>