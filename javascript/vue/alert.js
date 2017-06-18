Vue.component("alert",{
	template:"<transition v-on:before-enter='beforeEnter' v-on:after-enter='afterEnter' v-on:before-leave='beforeLeave' v-on:after-leave='afterLeave' >" +
				"<div class='alert fade' v-bind:class='[type,{in:isshow}]' v-show='isshow' >" +
					"<button v-on:click='hide' type='button' class='close'><span aria-hidden='true'>&times;</span></button>" +
					"<slot></slot>" +
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
		};
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
	}
})