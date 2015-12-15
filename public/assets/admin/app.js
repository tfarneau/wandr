var options = {
	url : "http://localhost:8000/api",
	routes : [
		{
			path : "/login",
			slug : "login",
			method : "POST",
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
			slug : "checkpoint",
			method : "GET",
			fields : [
				{
					name : "ll",
					label : "Latitude & longitude (required)",
					default_value : "48.8388423,2.4149193"
				},
				{
					name : "radius",
					label : "Rayon (km) (required)",
					default_value : "1000"
				},
				{
					name : "limit",
					label : "Limite (facultatif)",
					default_value : 10
				}
			]
		},
		{
			path : "/me",
			slug : "me",
			method : "GET",
			fields : [
				
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
		$(".json-"+type+" .json-data").JSONView(json);
	}

	this.callApi = function(method,path,params){

		var that = this;

		var data = {};
		for(var i in params){
			data[params[i].name] = params[i].value;
			path = path.replace('{'+params[i].name+'}',params[i].value);
		}

		this.logJSON(data,'query');

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


			if(data.token !== undefined){

		  		parent.token = data.token;
		  		$('.js-token').text('yep !');
		  		$('.js-status').text(200);

		  		var json = data;
		  		if(data.responseText !== undefined){ json =  { error : "crash" }; }
		  		if(data.responseJSON !== undefined){ json = data.responseJSON; }
		  		that.logJSON(json,'response');

		  		$.ajaxPrefilter(function( options ) {
				    if ( !options.beforeSend) {
				        options.beforeSend = function (xhr) { 
				            xhr.setRequestHeader('Authorization', 'Bearer '+parent.token);
				        }
				    }
				});

		  	}else{
		  		var json = data;
		  		if(data.responseText !== undefined){ json =  { error : "crash" }; }
		  		if(data.responseJSON !== undefined){ json = data.responseJSON; }
		  		that.logJSON(json,'response');
		  		$('.js-status').text(data.status);
		  	}

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
				
				html += '<p style="margin-top: 20px;">'+route.method+' on '+route.path+'</p>';
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