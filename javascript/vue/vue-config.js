(function(){

var myPlugin = {};
myPlugin.install = function(Vue){
    var _init = Vue.prototype._init;
    Vue.prototype._init = function(options){
        if ( options === void 0 ) options = {};
        var config = options.config;
        if(config && typeof config ==='object'){
            var keys = Object.keys(config);
            var i = keys.length;
            while(i--){
                Object.defineProperty(this,keys[i],{
                    value:config[keys[i]],
                });
            }
            delete options[config];
        }
        _init.call(this, options);
    }
}
Vue.use(myPlugin);

})();