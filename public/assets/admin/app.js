var options = {
	url : BASE_PATH,
	routes : [
		{
			path : "/login",
			slug : "login",
			method : "POST",
			secured : false,
			fields : [
				{
					name : "email",
					label : "Email",
					default_value : "ryanchenkie@gmail.com"
				},
				{
					name : "password",
					label : "Mot de passe",
					default_value : "secret"
				}
			]
		},
		{
			path : "/register",
			slug : "register",
			method : "POST",
			secured : false,
			fields : [
				{
					name : "email",
					label : "Email",
					default_value : "test@mail.com"
				},
				{
					name : "name",
					label : "Nom",
					default_value : "Jean-Pierre"
				},
				{
					name : "password",
					label : "Mot de passe",
					default_value : "password"
				}
			]
		},
		{
			path : "/checkpoints",
			slug : "checkpoints",
			secured : true,
			method : "GET",
			fields : [
				{
					name : "ll",
					label : "Latitude & longitude (required)",
					default_value : "48.8388423,2.4149193"
				},
				{
					name : "time",
					label : "temps en minutes",
					default_value : "40"
				},
				{
					name : "mode",
					label : "mode de transport : bike | foot",
					default_value : "foot"
				},
				{
					name : "type",
					label : "type : classic | sport",
					default_value : "sport"
				},
				{
					name : "limit",
					label : "Limite (facultatif)",
					default_value : 10
				}
			]
		},
		{
			path : "/calculate",
			slug : "calculate",
			secured : true,
			method : "GET",
			fields : [
				{
					name : "ll",
					label : "Latitude & longitude (required)",
					default_value : "48.8388423,2.4149193"
				},
				{
					name : "time",
					label : "temps en minutes",
					default_value : "40"
				},
				{
					name : "mode",
					label : "mode de transport : bike | foot",
					default_value : "foot"
				},
				{
					name : "type",
					label : "type : classic | sport",
					default_value : "sport"
				},
				{
					name : "limit",
					label : "Limite (facultatif)",
					default_value : 10
				},
				{
					name : "fs_ids",
					label : "Ids foursquare",
					default_value : "4d8db929d265236a4eadf816,4adcda09f964a520103421e3,4adcda0af964a5202a3421e3,4adcda0af964a520313421e3,4c40ed7bd691c9b6a9ff8b0a"
				}
			]
		},
		{
			path : "/me",
			slug : "me",
			secured : true,
			method : "GET",
			fields : [
				
			]
		},
		{
			path : "/me/requests",
			slug : "me_requests",
			secured : true,
			method : "GET",
			fields : [
				
			]
		},
		{
			path : "/me/itineraries",
			slug : "me_itineraries",
			secured : true,
			method : "GET",
			fields : [
				
			]
		},
		{
			path : "/me/itineraries/favorites",
			slug : "me_itineraries_favorites",
			secured : true,
			method : "GET",
			fields : [
				
			]
		},
		{
			path : "/me/itineraries/{id}",
			slug : "me_itinerary",
			secured : true,
			method : "GET",
			fields : [
				{
					name : "id",
					label : "id à rechercher",
					default_value : 1
				}
			]
		},
		{
			path : "/me/itineraries/{id}/favorite",
			slug : "me_itinerary_favorite",
			secured : true,
			method : "POST",
			fields : [
				{
					name : "id",
					label : "id de l'itinerary à favorite",
					default_value : 1
				}
			]
		},
		{
			path : "/me/itineraries/{id}/unfavorite",
			slug : "me_itinerary_unfavorite",
			secured : true,
			method : "POST",
			fields : [
				{
					name : "id",
					label : "id de l'itinerary à favorite",
					default_value : 1
				}
			]
		}
	]
};

var Api = function(options){

	this.root_url = options.url;
	this.options = options;
	this.token = null;

	var parent = this;

	this.logJSON = function(json,type){
		var collapsed = type == "response" ? true : false;
		$(".json-"+type+" .json-data").JSONView(json,{ collapsed : collapsed});
	}

	this.callApi = function(method,path,params){

		var that = this;

		var data = {};
		for(var i in params){
			data[params[i].name] = params[i].value;
			path = path.replace('{'+params[i].name+'}',params[i].value);
		}
		data['token'] = (parent.token);

		this.logJSON(data,'query');

		$('.js-loading').addClass('visible');

		if(method == "POST"){
			path += '?token='+parent.token;
		}

		$.ajax({
		  type: method,
		  url: parent.options.url+path,
		  data: data
		})
		.always(function( data, a ) {

			console.log("done ajax call")
			console.log(data);
			console.log(this);

			$('.js-lastpath').text(this.url);
			$('.js-lastmethod').text(this.type);


			if(data.data.token !== undefined){

		  		parent.token = data.data.token;
		  		$('.js-token').text('yep !');
		  		$('.js-status').text(200);

		  		var json = data;
		  		if(data.responseText !== undefined){ json =  { error : "crash" }; }
		  		if(data.responseJSON !== undefined){ json = data.responseJSON; }
		  		that.logJSON(json,'response');

		  		/*$.ajaxPrefilter(function( options ) {
				    if ( !options.beforeSend) {
				        options.beforeSend = function (xhr) { 
				            xhr.setRequestHeader('Authorization', 'Bearer '+parent.token);
				        }
				    }
				});*/

		  	}else{
		  		var json = data;
		  		if(data.responseText !== undefined){ json =  { error : "crash" }; }
		  		if(data.responseJSON !== undefined){ json = data.responseJSON; }
		  		that.logJSON(json,'response');
		  		$('.js-status').text(data.status);
		  	}

		  	$('.js-loading').removeClass('visible');

		});;

	}

	this.initLogin = function(){

		/*$('.js-login')
			.attr('name',parent.options.login.fields.login)
			.attr('value',parent.options.login.ids.login);
		$('.js-password')
			.attr('name',parent.options.login.fields.password)
			.attr('value',parent.options.login.ids.password);

		var that = this;
		$('.js-login').submit(function(e){
			e.preventDefault();
			that.callApi('POST',parent.options.login.path,$(this).serializeArray());
		});*/

	}

	this.initRoutes = function(){

		for(var i in parent.options.routes){

			var route = parent.options.routes[i];

			// Add route selector
			var tabClass = i == 0 ? 'active in' : '';
			$('.js-tabs').append('<li class="'+tabClass+'"><a href="#'+route.slug+'" data-toggle="tab">'+route.path+'</a></li>');

			// Add route div
			var html = '<div class="tab-pane fade '+tabClass +'" id="'+route.slug+'">';
				
				var badge = "";
				if(route.secured){
					badge = '<span class="label label-warning">Token required</span>';
				}
				html += '<p style="margin-top: 20px;">'+route.method+' on '+route.path+' '+badge+'</p>';
				html += '<form style="margin-top: 20px;" class="js-apiform" data-path="'+route.path+'" data-method="'+route.method+'">';

				for(var j in route.fields){
					html += '<div class="form-group">';
					html += '<label for="exampleInputFile">'+route.fields[j].label+' <em>'+route.fields[j].name+'</em></label>';
					html += '<input class="form-control" type="text" name="'+route.fields[j].name+'" value="'+route.fields[j].default_value+'">';
					html += '</div>';
				}
				html += '<button type="submit" class="btn btn-default">Submit</button></form></div>';

			$('.js-tabscontent').append(html);
		}

		var that = this;
		$('.js-apiform').submit(function(e){
			e.preventDefault();
			that.callApi($(this).attr('data-method'),$(this).attr('data-path'),$(this).serializeArray());
		});
	}

	this.init = function(url,options){

		this.initLogin();
		this.initRoutes();

	}

	this.init();

};

var API = new Api(options);