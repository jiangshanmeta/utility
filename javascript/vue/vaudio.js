(function(){

Vue.component("vaudio",{
	template:"<div v-on:click='_userClickHandler'><img v-bind:src='imgsrc' v-bind:class='imgclass' style='width:100%;' v-bind:loop='loop'   /><audio v-bind:autoplay='autoplay' v-bind:src='src'></audio></div>",
	props:{
		playimgsrc:{
			type:String,
			required:true,
		},
		pauseimgsrc:{
			type:String,
			required:true,
		},
		playimgclass:{
			type:String,
			default:'',
		},
		pauseimgclass:{
			type:String,
			default:'',
		},
		src:{
			type:String,
			required:true,
		},
		autoplay:{
			type:[String,Boolean],
			default:false,
		},
		loop:{
			type:[String,Boolean],
			default:true,
		},


	},
	data:function(){
		return {
			isPlaying:Boolean(this.autoplay),
			isUserPause:false,

		};
	},
	computed:{
		imgsrc:function(){
			if(this.isPlaying){
				return this.playimgsrc;
			}else{
				return this.pauseimgsrc;
			}
		},
		imgclass:function(){
			if(this.isPlaying){
				return this.playimgclass;
			}else{
				return this.pauseimgclass;
			}
		},
	},
	methods:{
		_play:function(){
			this.$audio.play();
			this.isPlaying = true;
		},
		_pause:function(){
			this.$audio.pause();
			this.isPlaying = false;
		},
		_userClickHandler:function(){
			if(this.isPlaying){
				this._pause();
				this.isUserPause = true;
			}else{
				this._play();
				this.isUserPause = false;
			}
		},
		play:function(){
			if(!this.isUserPause && !this.isPlaying){
				this._play();
			}
		},
		pause:function(){
			if(this.isPlaying){
				this._pause();
			}
			
		},


	},
	mounted:function(){
		this.$nextTick(function(){
			this.$audio = this.$el.querySelector('audio');
		})
	}

})

})(Vue);