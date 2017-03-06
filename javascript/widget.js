// 抽象出公用方法 作为组件类的基类
function Widget(){

}
Widget.prototype = {
	constructor:Widget,
	// 观察者模式
	$on:function(type,handler){
		if(!this._handlers){
			this._handlers = Object.create(null);
		}
		if(gettype(type)==='object'){
			for(key in type){
				if(type.hasOwnProperty(key)){
					this.$on(key,type[key]);
				}
			}
		}else if(typeof handler === 'function'){
			if(!this._handlers[type]){
				this._handlers[type] = [];
			}
			this._handlers[type].push(handler);
		}
		return this;
	},
	$once:function(type,fn){
		// once只是对on的一层包装，保证回调只用一次
		var _this = this;
		var fn2 = function(){
			_this.$off(type,fn2);
			fn.apply(_this,arguments);
		}
		return this.$on(type,fn2);
	},
	$emit:function(type){
		if(!this._handlers || !this._handlers[type]){
			return this;
		}
		var handlers = this._handlers[type];
		var args = [].slice.call(arguments,1);
		for(var i=0,len=handlers.length;i<len;i++){
			handlers[i].apply(this,args);
		}
		return this;
	},
	$off:function(type,handler){
		// 不传参数默认把事件全干掉
		var l = arguments.length;

		if(!l){
			this._handlers = Object.create(null);
			return this;
		}
		if(!this._handlers || !this._handlers[type]){
			return this;
		}
		// 如果只有类型没有具体的函数，干掉这个事件
		if(l===1){
			this._handlers[type] = [];
			return this;
		}
		handlers = this._handlers[type];
		for(var i=0,len=handlers.length;i<len;i++){
			if(handlers[i]===handler){
				this._handlers[type].splice(i,1);
				break;
			}
		}
		return this;
	},
	_bindEvent:function(eventName,optionName){
		if(gettype(eventName)==='object'){
			for(key in eventName){
				this._bindEvent(key,eventName[key]);
			}
		}else if(gettype(this.options[optionName])==='function'){
			this.$on(eventName,this.options[optionName]);
		}
		return this;
	},
	_mergeOpt:function(opt){
		// 合并传入的参数，因为js参数默认值有兼容性问题，所以写死两个参数， 合并后的参数以options挂在this上，默认值是公有静态变量defaults
		this.options = deepAssign({},this.constructor.defaults,opt||{});
	},
	_bindContainer:function(){
		var selector = this.options.selector;
		var isId = /^#[\w-]+$/.test(selector);
		var context = isId?document:(this.options.context&&(this.options.context.nodeType===1 ||this.options.context.nodeType===9)?this.options.context:document);
		this.container = context.querySelector(this.options.selector);
	},
	$watch:function(name,fn){
		if(typeof fn !== 'function'){
			return this;
		}
		var context = this;
		var proxy = function(id,oldVal,newVal){
			return fn.call(context,oldVal,newVal);
		}
		this.watch(name,proxy);
		return this;
	},
	__get = function(fn,ctx){
		return new Proxy(ctx?ctx:this,{
			get:function(target,name){
				return name in target? target[name]:fn.call(target,name);
			}
		});
	},

}