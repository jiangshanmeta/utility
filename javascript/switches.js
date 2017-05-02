(function(global){
	function whichTransitionEvent(){  
	    var t;  
	    var el = document.createElement('p');  
	    var transitions = {  
	      'transition':'transitionend',  
	      'OTransition':'oTransitionEnd',  
	      'MozTransition':'mozTransitionEnd',  
	      'WebkitTransition':'webkitTransitionEnd',  
	      'MsTransition':'msTransitionEnd'  
	    }  
	    for(t in transitions){  
	        if( el.style[t] !== undefined ){  
	            return transitions[t];  
	        }  
	    }  
	}

	var defaults = {
		context:document,
		status:0,    // 0表示off 1表示on

	};
	var activeClass = 'at-switch-active';
	var endEvent = whichTransitionEvent();

	function Switches(opt){
		if(!(this instanceof Switches)){
			return new Switches(opt);
		}
		if(!opt || !opt.selector){
			console.error('the selector input is necessary');
			return;
		}
		var options = Object.assign({},defaults,opt);
		this.$ele = options.context.querySelector(options.selector);
		if(!this.$ele){
			console.error('wrong selector');
			return;
		}

		this._init(options);
	}

	Switches.prototype = {
		_fixStatus:function(options){
			var status = options.status;
			var domStatus = Number(this.$ele.classList.contains(activeClass));
			if(domStatus!==status){
				this._setStatus(status);
			}
			this._status = status;
			return this;
		},
		_init:function(options){
			
			this._initEvent();
			this._fixStatus(options);
			this._isTransition = false;
			return this;
		},
		_initEvent:function(){
			this.$ele.addEventListener("click",this.toggleStatus.bind(this),false);
			this.$ele.addEventListener(endEvent,function(){
				this._isTransition = false;
			}.bind(this),false);
			return this;
		},
		getStatus:function(){
			return this._status;
		},
		_setStatus:function(status){
			if(this._isTransition){
				return this;
			}
			var curStatus = this.getStatus();
			if(curStatus===status){
				return this;
			}

			if(status===1 || status===0){
				this._isTransition = true;
				this._status = status;
				this.$ele.classList.toggle(activeClass);

			}
			return this;
		},
		on:function(){
			return this._setStatus(1);
		},
		off:function(){
			return this._setStatus(0);
		},
		toggleStatus:function(){
			var status = this.getStatus();
			if(status===0){
				return this.on();
			}else{
				return this.off();
			}
		}
	};

	Object.defineProperty(Switches.prototype,'constructor',{
		value:Switches,
		writable:false,
		configurable:false,
		enumrable:false,
	});

	var _old = global.Switches;
	Switches.noConflict = function(){
		global.Switches = _old;
		return Switches;
	}

	global.Switches = Switches;
})(window);