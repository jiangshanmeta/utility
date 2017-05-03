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


	var instance = null;
	var defaults = {
		time:1000,
	};
	var endEvent = whichTransitionEvent();
	var cfg = {
		container:'at-toast-container',
		active:'at-toast-active',
		msg:'at-toast-message',
	};



	// status 0=>未显示 1=>淡入中 2=>正常显示 3=>淡出中 

	function Toast(opt){
		if(instance instanceof Toast){
			return instance;
		}
		if(!(this instanceof Toast)){
			return new Toast(opt);
		}

		this._status = 0;

		var container = document.createElement('div');
		container.classList.add(cfg.container);
		container.style['display'] = 'none';
		this._container = container;

		var messageDOM = document.createElement('div');
		messageDOM.classList.add(cfg.msg);
		this._msgDOM = messageDOM;
		this._container.appendChild(this._msgDOM);

		this._interval = null;

		opt = Object.assign({},defaults,opt||{});
		this.set(opt);
		this._bindEvent();
		document.body.appendChild(this._container);
	}

	Toast.prototype = {
		set:function(key,value){
			if(typeof key==='object'){
				for(k in key){
					if(k in defaults){
						this.set(k,key[k]);
					}
				}
				return this;
			}
			if(key in defaults){
				this[key] = value;
			}
			return this;
		},
		_bindEvent:function(){
			this._container.addEventListener(endEvent,function(){
				if(this._container.classList.contains(cfg.active)){
					this._status = 2;
					this._setInterval();
				}else{
					this._status = 0;
					this._container.style['display'] = 'none';
				}
			}.bind(this),false);
		},
		_setInterval:function(){
			this._interval && clearTimeout(this._interval);
			this._interval = setTimeout(function(){
				this._status = 3;
				this._container.classList.remove(cfg.active);
			}.bind(this),this.time);
		},
		_setMsg:function(msg){
			this._msgDOM.innerHTML = msg;
		},
		show:function(msg){
			if(this._status === 0){
				var _this = this;
				this._status = 1;
				this._setMsg(msg);
				this._container.style['display'] = 'block';
				setTimeout(function(){
					_this._container.classList.add(cfg.active);
				},0);
				
			}else if(this._status === 1){
				this._setMsg(msg);
			}else if(this._status === 2){
				this._setMsg(msg);
				this._setInterval();
			}else{
				this._container.classList.add(cfg.active);
				this._setMsg(msg);
				this._status = 1;

			}
		},

	};
	Object.defineProperty(Toast.prototype,'constructor',{
		value:Toast,
		writable:false,
		configurable:false,
		enumrable:false,
	});

	var _old = global.Toast;
	Toast.noConflict = function(){
		global.Toast = _old;
		return Toast;
	}
	global.Toast = Toast;
})(window);