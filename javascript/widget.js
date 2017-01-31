// 抽象出公用方法 作为组件类的基类
function Widget(){

}
Widget.prototype = {
	constructor:Widget,
	// 观察者模式
	on:function(type,handler){
		if(gettype(handler)==='function'){
			if(!this._handlers){
				this._handlers = {};
			}
			if(!this._handlers[type]){
				this._handlers[type] = [];
			}
			this._handlers[type].push(handler);
		}
		return this;
	},
	fire:function(type,data){
		if(!this._handlers){
			this._handlers = {};
		}
		if(this._handlers[type]){
			var handlers = this._handlers[type];
			for(var i=0,len=handlers.length;i<len;i++){
				handlers[i](data);
			}
		}
		return this;
	},
	remove:function(type,handler){
		if(!this._handlers){
			this._handlers = {};
		}
		if(this._handlers[type]){
			handlers = this._handlers[type];
			for(var i=0,len=handlers.length;i<len;i++){
				if(handlers[i]===handler){
					this._handlers[type].splice(i,1);
					break;
				}
			}
		}
		return this;
	},
	_bindEvent:function(eventName,optionName){
		if(gettype(this.options[optionName])==='function'){
			this.on(eventName,this.options[optionName]);
		}
	}
}