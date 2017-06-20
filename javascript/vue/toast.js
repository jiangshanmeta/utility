(function(){

var template = 
"<transition v-on:after-enter='afterEnter' v-on:after-leave='afterLeave'>" +
	"<div class='v-toast-container' v-show='isshow' v-bind:class='[{\"v-toast-active\":isshow}]' style='display:block;' >" +
		"<div class='v-toast-message'>{{text}}</div>" +
	"</div>" +
"</transition>";

var instance = null;
// status 0=>未显示 1=>淡入中 2=>正常显示 3=>淡出中 
var status = 0;
var time = 0;
var interval = null;
var defaults = {
	'duration':1500,
};
var data = {
	isshow:false,
	text:'',
};


function get_instance(){
	if(!(instance instanceof Vue)){
		instance = new Vue({
			template:template,
			data:data,			
			methods:{
				show:function(msg,duration){
					time = (duration && Number(duration)) || defaults.duration;
					this.text = msg;
					if(status === 0){
						status = 1;
						this.isshow = true;
					}else if(status === 1){

					}else if(status === 2){
						this._setInterval();
					}else{
						this.isshow = true;
						status = 1;
					}
				},
				hide:function(){
					status = 3;
					this.isshow = false;
				},
				afterEnter:function(){
					status = 2;
					this._setInterval();
				},
				afterLeave:function(){
					status = 0;
				},
				_setInterval:function(){
					interval && clearTimeout(interval);
					interval = setTimeout(function(){
						this.hide();
					}.bind(this),time);
				},
			},

		})
		instance.$mount();
		document.body.appendChild(instance.$el);
	}
	return instance;
}


var toast = function(text,duration){
	var instance = get_instance();
	instance.show(text,duration);
}

Vue.toast = Vue.prototype.$toast = toast;

})();