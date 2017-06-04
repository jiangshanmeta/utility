(function(Vue){

var isInArea = function(shape,coords,DOMInfo,eventInfo){
	var coordsInfo = coords.split(",");
	shape = shape.trim();
	switch(shape){
		case 'circle':
			preTreatPoly(coordsInfo,DOMInfo);
			if(Math.pow(eventInfo.x-coordsInfo[0],2)+Math.pow(eventInfo.y-coordsInfo[1],2)<Math.pow(coordsInfo[2],2)){
				return true;
			}
			break;
		case 'rect':
			preTreatPoly(coordsInfo,DOMInfo);
			return isBetween(eventInfo.x,coordsInfo[0],coordsInfo[2])&&isBetween(eventInfo.y,coordsInfo[1],coordsInfo[3]);
			break;
		case 'poly':
			preTreatPoly(coordsInfo,DOMInfo);
			serializedCoordsInfo = serializePoly(coordsInfo);
			return isInPoly(eventInfo,serializedCoordsInfo);
			break;
	}
	return false;
}
var isPercent = function(num){
	return String(num).indexOf("%")>-1;
}
var isBetween = function(selected,min,max){
	if(min>max){
		var tmp = min;
		min = max;
		max = tmp;
	}
	return selected>=min&&selected<=max;
}
var serializePoly = function(coordsInfo){
	var rst = [];
	for(var i=0,len=coordsInfo.length;i<len;i++){
		if(i%2===0){
			rst.push({x:coordsInfo[i]});
		}else{
			rst[rst.length-1].y = coordsInfo[i];
		}
	}
	return rst;
}

var preTreatPoly = function(coordsInfo,DOMInfo){
	var item;
	for(var i=0,len=coordsInfo.length;i<len;i++){
		item = coordsInfo[i];
		if(isPercent(item)){
			coordsInfo[i] = parseFloat(item)*DOMInfo[i%2===0?'x':'y']/100;
		}
	}
}

function isInPoly(p, poly) {
	var px = p.x,
		py = p.y,
		flag = false

	for(var i = 0, l = poly.length, j = l - 1; i < l; j = i, i++) {
		var sx = poly[i].x,
			sy = poly[i].y,
			tx = poly[j].x,
			ty = poly[j].y
		if((sx === px && sy === py) || (tx === px && ty === py)) {
			return true;
		}
		if((sy < py && ty >= py) || (sy >= py && ty < py)) {
			var x = sx + (py - sy) * (tx - sx) / (ty - sy)
			if(x === px) {
				return true;
			}
			if(x > px) {
				flag = !flag
			}
		}
	}

	return flag;
}

var eventHandler = function(event,component){
	var DOMInfo = {
		x:component.$el.clientWidth,
		y:component.$el.clientHeight
	};
	var eventInfo = {
		x:event.offsetX,
		y:event.offsetY
	};
	var eventType = event.type;
	var checkHref = eventType==='click'?true:false;
	var map = component.map;
	var area,handler,bracketIndex,funcName;
	for(var i =0,len=map.length;i<len;i++){
		area = map[i];
		if( (area['on'] && area['on'][eventType]) || (checkHref && area['href'])   ){
			// TODO，判断是否在范围
			if(!isInArea(area['shape'],area['coords'],DOMInfo,eventInfo)){
				continue;
			}

			if(checkHref && area['href']){
				window.open(area['href'],area['target']);
				continue;
			}

			handler = area['on'][eventType];
			if((bracketIndex = handler.indexOf('('))>-1 ){
				funcName = handler.slice(0,bracketIndex);
				var arg = handler.slice(bracketIndex+1,-1).split(',');
				component.$parent[funcName].apply(component.$parent,arg);
			}else{
				component.$parent[handler]();
			}
		}
	}
}

Vue.component('mapimg',{
	template:'<img>',
	props:{
		'map':{
			type:Array,
			required:true,
		}
	},
	mounted:function(){
		var map = this.map;
		var area,k,keys;
		var eventHash = {};
		for(var i=0,len=map.length;i<len;i++){
			area = map[i];
			if(typeof area['on'] === 'object'){
				keys = Object.keys(area['on']);
				for(var j=0,onLen=keys.length;j<onLen;j++){
					k = keys[j];
					if(eventHash[k]){
						continue;
					}
					this.$el.addEventListener(k,function(e){
						eventHandler(e,this);
					}.bind(this));
					eventHash[k] = true;
				}
			}
		}
	
	}
});

})(Vue);