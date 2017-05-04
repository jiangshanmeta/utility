(function(global){
	var instance = null;
	var cfg = {
		'pushyCls':'.at-pushy',
		'activeCls':'at-pushy-active',
		'backdropCls':'.at-pushy-backdrop',
	};

	function Pushy(){
		if(instance instanceof Pushy){
			return instance;
		}
		if(!(this instanceof Pushy)){
			return new Pushy();
		}
		this._container = document.querySelector(cfg['pushyCls']);
		if(!this._container){
			console.error('Pushy need preset HTML');
			return;
		}
		this._backgrop = this._container.querySelector(cfg['backdropCls']);
		this._backgrop && this._backgrop.addEventListener("click",function(){
			this.close();
		}.bind(this),false);
	}

	Pushy.prototype = {
		open:function(){
			var isOpen = this.isOpen();
			if(!isOpen){
				this._container.classList.add(cfg['activeCls']);
			}
		},
		close:function(){
			var isOpen = this.isOpen();
			if(isOpen){
				this._container.classList.remove(cfg['activeCls']);
			}
		},
		isOpen:function(){
			return this._container.classList.contains(cfg['activeCls']);
		}
	};

	var _old = global.Pushy;
	Pushy.noConflict = function(){
		global.Pushy = _old;
		return Pushy;
	}
	global.Pushy = Pushy;
})(window);