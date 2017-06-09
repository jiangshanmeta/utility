(function(Vue){

Vue.component("grayimg",{
	template:"<div style='position:relative'><img v-bind:src='src' style='width:100%;' v-bind:class='grayclass'><div v-bind:style='boxStyle' style='position:absolute;overflow:hidden;'><img v-bind:src='src' v-bind:style='imgStyle' style='position:absolute;'></div></div>",
	props:{
		ratio:{
			type:[Number,String],
			required:true,
		},
		src:{
			type:String,
			required:true,
		},
		grayclass:{
			type:String,
			default:"grayimg",
		},
		dir:{
			validator:function(value){
				return ['btt','ttb','ltr','rtl'].indexOf(value)>-1;
			},
			default:"btt",
		}
	},
	computed:{
		boxStyle:function(){
			var rst = {};
			switch(this.dir){
				case 'btt':
					rst['bottom'] = 0;
					rst['left'] = 0;
					rst['right'] = 0;
					rst['height'] = this.ratio*100 + "%";
					break;
				case 'ttb':
					rst['left'] = 0;
					rst['right'] = 0;
					rst['top'] = 0;
					rst['height'] = this.ratio*100 + "%";
					break;
				case 'ltr':
					rst['top'] = 0;
					rst['bottom'] = 0;
					rst['left'] = 0;
					rst['width'] = this.ratio*100 + "%";
					break;
				case 'rtl':
					rst['top'] = 0;
					rst['bottom'] = 0;
					rst['right'] = 0;
					rst['width'] = this.ratio*100 + "%";
					break;
			}

			return rst;
		},
		imgStyle:function(){
			var rst = {};
			switch(this.dir){
				case 'btt':
					rst['width'] = "100%";
					rst['bottom'] = 0;
					break;
				case 'ttb':
					rst['width'] = "100%";
					rst['top'] = 0;
					break;
				case 'ltr':
					rst['height'] = "100%";
					rst['left'] = 0;
					break;
				case 'rtl':
					rst['height'] = "100%";
					rst['right'] = 0;
					break;
			}

			return rst;
		}
	}
})


})(Vue);