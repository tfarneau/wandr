var root_url = BASE_PATH;


function goStep(index){

	var pIndex = index-1;
	$('.js-step'+pIndex+'-block').removeClass('visible');
	setTimeout(function(){
		$('.js-step'+pIndex+'-block').addClass('gone');
		$('.js-step'+index+'-block').removeClass('gone');
		setTimeout(function(){
			$('.js-step'+index+'-block').addClass('visible');
		},100);
	},1000);

}

// Step 1

$('.js-step1-block').removeClass('gone');
setTimeout(function(){
	$('.js-step1-block').addClass('visible');
},500);

$('.js-step1').submit(function(e){
	e.preventDefault();

	$('.js-loading').addClass('visible');

	console.log("trigger step 1")

	$.ajax({
	  type: "POST",
	  url: root_url+"/login",
	  data: $(this).serializeArray()
	})
	.always(function(data, a) {

		if(data.data.token !== undefined){

	  		$('.js-step1-status').text('Login success !');

	  		$.ajaxPrefilter(function( options ) {
			    if ( !options.beforeSend) {
			        options.beforeSend = function (xhr) { 
			            xhr.setRequestHeader('Authorization', 'Bearer '+data.data.token);
			        }
			    }
			});

			goStep(2);

			// Init map
			
			setTimeout(function(){

				$('.js-loading').removeClass('visible');

				var mapLocationPicker;

				var myLatlng = new google.maps.LatLng(48.8518724,2.4205645);

				var myOptions = {
				    zoom: 13,
				    center: myLatlng,
				    mapTypeId: google.maps.MapTypeId.ROADMAP,
				    // scrollwheel: false
				};

				mapLocationPicker = new google.maps.Map(document.getElementById("point-map"), myOptions);

				var marker = new google.maps.Marker({
				    draggable: true,
				    position: myLatlng,
				    map: mapLocationPicker,
				    title: "Your location"
				});

				$('.js-pointlat').val(myLatlng.lat());
				$('.js-pointlng').val(myLatlng.lng());

				google.maps.event.addListener(marker, 'dragend', function (event) {
				    $('.js-pointlat').val(event.latLng.lat());
				    $('.js-pointlng').val(event.latLng.lng());
				});

			},2000);

	  	}else{
	  		$('.js-step1-status').text('Login error');
	  	}

	});;

});

// Step 2

var step2_data = null;
$('.js-step2').submit(function(e){
	e.preventDefault();

	$('.js-loading').addClass('visible');

	console.log("trigger step 2");

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

		goStep(3);

		$('.js-step2-status').text('success !');

		var html = "";
		for(var i in data.data){

			var styleClass = Math.round(Math.random()) == 0 ? 'selected' : '';

			console.log(data.data[i])
			console.log(data.data[i].photo_original)
			html += '<div class="col-md-4 cardcontainer js-card '+styleClass+'" data-fsid="'+data.data[i].fs_id+'">';
			html += '<div class="card">';
			html += '<div class="cardimage" style="background-image:url('+data.data[i].photo_original+')"></div>';
			html += '<div class="cardcontent">';
			html += '<h4>'+data.data[i].name+'</h4>';
			html += '<p>'+data.data[i].rating+'/10.<br>'+data.data[i].checkin_count+' checkins</p>';
			html += '</div>';
			html += '</div></div>';
		}

		$('.js-checkpoints').html(html);

		$('.js-card').on('click',function(){
			$(this).toggleClass('selected');
		});

		setTimeout(function(){
			$('.js-loading').removeClass('visible');
		},2000);

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

	$('.js-loading').addClass('visible');

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

		$('.js-metadistance').text(data.data.metas.total_distance/1000+"km");
		$('.js-metatime').text(data.data.metas.time_minutes+" minutes");

		var html = "";
		for(var i in data.data.checkpoints){
			if(data.data.checkpoints[i].name !== "home"){
				html += '<div class="col-md-4 cardcontainer selectable js-card" data-fsid="'+data.data.checkpoints[i].fs_id+'">';
				html += '<div class="card">';
				html += '<div class="cardimage" style="background-image:url('+data.data.checkpoints[i].photo_original+')"></div>';
				html += '<div class="cardcontent">';
				html += '<h4>'+data.data.checkpoints[i].name+'</h4>';
				html += '<p>'+data.data.checkpoints[i].rating+'/10.<br>'+data.data.checkpoints[i].checkin_count+' checkins</p>';
				html += '</div>';
				html += '</div></div>';
			}
		}

		$('.js-checkpoints2').html(html);

		data = data.data;

		goStep(4);

		setTimeout(function(){

			$('.js-loading').removeClass('visible');

			directionsDisplay = new google.maps.DirectionsRenderer({
		        suppressMarkers: true
		    });

		    var myOptions = {
		        zoom: 3,
		        mapTypeId: google.maps.MapTypeId.ROADMAP,
		        // scrollwheel: false
		    };

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

		},2000);

	});
});