var vuemixin = {
	showHide:{
		methods:{
			showField:function(field){
				this[field] = true;
			},
			hideField:function(field){
				this[field] = false;
			},
			toggleField:function(field){
				this[field] = !this[field];
			}
		}
	},
	// 针对vaudio组件的mixin
	vaudio:{
		methods:{
			playAudio:function(refName){
				this.$refs[refName].play();
			},
			pauseAudio:function(refName){
				this.$refs[refName].pause();
			},
		},
	}
}