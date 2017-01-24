// 聚合一些常用的业务逻辑代码
var utility = {
	is_mobile:function(mobile){
		return (/^1\d{10}$/).test(mobile);
	},
	chk_pwd:function(pwd){
		return (/^[a-zA-Z0-9_]{6,16}$/).test(pwd);
	},
	chk_email:function(email){
		return (/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9]+(-[a-zA-Z0-9]+)*(\.[a-zA-Z0-9]+[-a-zA-Z0-9]*)+[a-zA-Z0-9]+$/).test(email);
	},
	chk_zipcode:function(zipcode){
		return (/^\d{6}$/).test(zipcode);
	},
	chk_idno:function(id){
		return (/^\d{17}[0-9X]{1}$/).test(id);
	},
	chk_plateno:function(plateno){
		plateno = plateno.trim();
		if(plateno==='临牌'){
			return true;
		}
		var len = plateno.length;
		if(len===7||len===8){
			return true;
		}
		return false;
	},

}