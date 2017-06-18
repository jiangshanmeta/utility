Vue.component("modal",{
	template:"<transition v-on:before-enter='beforeEnter' v-on:after-enter='afterEnter' v-on:before-leave='beforeLeave' v-on:after-leave='afterLeave'>"+
				"<div class='modal fade' style='display:block' v-show='isshow' v-bind:class='[{in:isshow}]'>" +
					"<div class='modal-backdrop' v-on:click='hide' style='z-index:0;' v-bind:class='[{in:isshow}]'></div>" +
					"<div class='modal-dialog' v-bind:class='[type]' style='z-index:1;height:100%;margin-top:0;margin-bottom:0;'>"+
						"<div class='modal-content' style='width:100%;position:absolute;top:50%;left:50%;-webkit-transform:translate(-50%,-50%);transform:translate(-50%,-50%);'>" +
							"<div class='modal-header'>" +
								"<button v-on:click='hide' class='close' aria-label='Close'><span aria-hidden='true'>&times;</span></button>" +
								"<slot name='header'></slot>" +
							"</div>" +
							"<div class='modal-body'><slot></slot></div>" +
							"<div class='modal-footer'><slot name='footer'></slot></div>" +
						"</div>" +
					"</div>" +
				"</div>" +
			"</transition>",
	props:{
		type:{
			'type':String,
			'default':'',
		},
	},
	data:function(){
		return {
			isshow:false,
		}
	},
	methods:{
		show:function(){
			this.isshow = true;
		},
		hide:function(){
			this.isshow = false;
		},
		beforeEnter:function(){
			this.$emit('show');
		},
		afterEnter:function(){
			this.$emit('shown');
		},
		beforeLeave:function(){
			this.$emit('hide');
		},
		afterLeave:function(){
			this.$emit('hidden');
		},
	},

})