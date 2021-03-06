(function(){

var template = 
"<transition >" +
"<div class='v-popup-backdrop' v-show='isshow' v-bind:class='[{\"v-active\":isshow}]' v-on:click.self='success'  >" +
	"<div class='v-popup'  v-bind:class='[{\"v-popup-in\":isshow}]'>" +
		"<div class='v-popup-inner'>" +
			"<div v-if='title' class='v-popup-title'>{{title}}</div>" +
			"<div class='v-popup-text'>{{text}}</div>" +
		"</div>" +
		"<div class='v-popup-buttons'>" +
			"<span class='v-popup-button' v-on:click='success'>{{btntext}}</span>" +
		"</div>" +
	"</div>" +
"</div>" +
"</transition>";

var instance = null;
var defaults = {
	'title':'',
	'btntext':'确定',
};

var data = Object.assign({},defaults);
data['isshow'] = false;
data['text'] = '';

function get_instance(){
	if(!(instance instanceof Vue)){
		instance = new Vue({
			template:template,
			data:data,			
			methods:{
				success:function(){
					this.isshow = false;
				},
			},

		})
		instance.$mount();
		document.body.appendChild(instance.$el);
	}
	return instance;
}

var alert = function(text,opt){
	var instance = get_instance();
	if(typeof text ==='object'){
		opt = text;
		text = opt.text;
		delete opt['text'];
	}

	instance.text = text;
	Object.assign(instance,defaults,opt || {});
	instance.isshow = true;
	var _success = instance.success;
	return new Promise(function(resolve,reject){
		instance.success = function(){
			_success();
			instance.success = _success;
			resolve();
		}
	});
}

Vue.alert = Vue.prototype.$alert = alert;


})();