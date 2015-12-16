var root_url = BASE_PATH;

// Step 1

$('.js-step1').submit(function(e){
	e.preventDefault();

	console.log("trigger step 1")

	$.ajax({
	  type: "POST",
	  url: root_url+"/login",
	  data: $(this).serializeArray()
	})
	.always(function(data, a) {

		if(data.token !== undefined){

	  		$('.js-step1-status').text('success !');

	  		$.ajaxPrefilter(function( options ) {
			    if ( !options.beforeSend) {
			        options.beforeSend = function (xhr) { 
			            xhr.setRequestHeader('Authorization', 'Bearer '+data.token);
			        }
			    }
			});

	  	}else{
	  		$('.js-step1-status').text('login error');
	  	}

	});;

});

// Step 2

var step2_data = null;
$('.js-step2').submit(function(e){
	e.preventDefault();

	console.log("trigger step 2")

	var data = $(this).serializeArray();
	data.push({
		name: "ll",
		value: $('input[name="lat"]').val()+","+$('input[name="lng"]').val()
	});

	step2_data = data;

	$.ajax({
	  type: "GET",
	  url: root_url+"/checkpoints",
	  data:data
	})
	.always(function(data, a) {

		$('.js-step2-status').text('success !');

		var html = "";
		for(var i in data.data){
			console.log(data.data[i])
			console.log(data.data[i].photo_original)
			html += '<div class="col-md-4 cardcontainer js-card" data-fsid="'+data.data[i].fs_id+'">';
			html += '<div class="card">';
			html += '<div class="cardimage" style="background-image:url('+data.data[i].photo_original+')"></div>';
			html += '<div class="cardcontent">';
			html += '<h4>'+data.data[i].name+'</h4>';
			html += '<p>'+data.data[i].rating+'/10. '+data.data[i].tip+'</p>';
			html += '</div>';
			html += '</div></div>';
		}

		$('.js-checkpoints').html(html);

		$('.js-card').on('click',function(){
			$(this).toggleClass('selected');
		});

	});

});

// Step 3

var directionDisplay;
var directionsService = new google.maps.DirectionsService();
var map;

function createMarker(latlng) {
    
    var marker = new google.maps.Marker({
        position: latlng,
        map: map
    });
}

$('.js-step3').on('click',function(e){
	e.preventDefault();

	var data = step2_data;
	var fs_ids = "";
	$('.js-card.selected').each(function(i,el){
		fs_ids += $(el).attr('data-fsid')+",";
	})
	fs_ids = fs_ids.slice(0, -1);

	data.push({
		name: 'fs_ids',
		value: fs_ids
	});

	$.ajax({
	  type: "GET",
	  url: root_url+"/calculate",
	  data:data
	})
	.always(function(data, a) {

		directionsDisplay = new google.maps.DirectionsRenderer({
	        suppressMarkers: true
	    });

	    var myOptions = {
	        zoom: 3,
	        mapTypeId: google.maps.MapTypeId.ROADMAP,
	    }

	    map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);
	    directionsDisplay.setMap(map);

	    var waypts = [];
	    for(var i in data.checkpoints){
	    	waypts.push({
		        location: new google.maps.LatLng(data.checkpoints[i].lat, data.checkpoints[i].lng),
		        stopover: true
		    });
	    }

	    start = new google.maps.LatLng(data.checkpoints[0].lat, data.checkpoints[0].lng);
	    end = start;
	    
	    createMarker(start);
	    
	    var request = {
	        origin: start,
	        destination: end,
	        waypoints: waypts,
	        optimizeWaypoints: true,
	        travelMode: google.maps.DirectionsTravelMode.WALKING
	    };

	    directionsService.route(request, function (response, status) {
	        if (status == google.maps.DirectionsStatus.OK) {
	            directionsDisplay.setDirections(response);
	            var route = response.routes[0];
	        }
	    });

	});
});