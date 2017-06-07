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
	}
}