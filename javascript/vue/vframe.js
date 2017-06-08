(function(Vue){

Vue.component("vframe",{
	template:"<div style='position:relative;'><div v-bind:style='{paddingBottom:(ratio*100) +\"%\"}'></div><iframe v-bind:src='src' frameborder='0' allowfullscreen    style='position:absolute;top:0;left:0;width:100%;height:100%;'></iframe><slot></slot></div>",
	props:{
		src:{
			type:String,
			required:true,
		},
		ratio:{
			type:Number,
			required:true,
		}
	},

});

})(Vue);