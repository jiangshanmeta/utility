(function(){

var template = 
"<transition >" +
"<div class='v-popup-backdrop' v-show='isshow' v-bind:class='[{\"v-active\":isshow}]' v-on:click.self='cancel'  >" +
	"<div class='v-popup'  v-bind:class='[{\"v-popup-in\":isshow}]'>" +
		"<div class='v-popup-inner'>" +
			"<div v-if='title' class='v-popup-title'>{{title}}</div>" +
			"<div class='v-popup-text'>{{text}}</div>" +
			"<div class='v-popup-input'><input v-model='prompt' v-bind:placeholder='placeholder'></div>" +
		"</div>" +
		"<div class='v-popup-buttons'>" +
				"<span class='v-popup-button' v-on:click='success'>{{yestext}}</span>" +
				"<span class='v-popup-button' v-on:click='cancel'>{{notext}}</span>" +
		"</div>" +
	"</div>" +
"</div>" +
"</transition>";

var instance = null;
var defaults = {
	'title':'',
	'placeholder':'',
	'yestext':'是',
	'notext':'否',
	'prompt':''

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
				cancel:function(){
					this.isshow = false;
				},
			},

		})
		instance.$mount();
		document.body.appendChild(instance.$el);
	}
	return instance;
}

var prompt = function(text,opt){
	var instance = get_instance();
	if(typeof text ==='object'){
		opt = text;
		text = opt.text;
		delete opt['text'];
	}
	delete opt['prompt'];

	instance.text = text;
	Object.assign(instance,defaults,opt || {});
	instance.isshow = true;

	var _success = instance.success;
	var _cancel = instance.cancel;

	return new Promise(function(resolve,reject){
		instance.success = function(){
			_success();
			instance.success = _success;
			instance.cancel = _cancel;
			resolve(instance.prompt);
		}
		instance.cancel = function(){
			_cancel();
			instance.success = _success;
			instance.cancel = _cancel;
			reject();
		}
	})

};

Vue.prompt = Vue.prototype.$prompt = prompt;

})();