// 设定Cookie值
function SetCookie(name, value) {
	var expdate = new Date();
	var argv = SetCookie.arguments;
	var argc = SetCookie.arguments.length;
	var expires = (argc > 2) ? argv[2] : null;
	var path = (argc > 3) ? argv[3] : null;
	var domain = (argc > 4) ? argv[4] : null;
	var secure = (argc > 5) ? argv[5] : false;
	if (expires != null)
		expdate.setTime(expdate.getTime() + (expires * 1000));
	document.cookie = name + "=" + escape(value)
			+ ((expires == null) ? "" : ("; expires=" + expdate.toGMTString()))
			+ ((path == null) ? "" : ("; path=" + path))
			+ ((domain == null) ? "" : ("; domain=" + domain))
			+ ((secure == true) ? "; secure" : "");
}

function setCookie(arr) {
	 for (i = 0; i < arr.elements.length; i++) {
		    var key=arr.elements[i].key;
        	//document.cookie = key+ "="+arr.elements[i].value+";";
        	SetCookie(key,arr.elements[i].value);
        } 
}

// 获得Cookie的原始值
function GetCookie(name) {
	var arg = name + "=";
	var alen = arg.length;
	var clen = document.cookie.length;
	var i = 0;
	var cookie = document.cookie;
	while (i < clen) {
		var j = i + alen;
		if (cookie.substring(i, j) == arg){ 
			var c=cookie.substring(i, j);
			var co=GetCookieVal(j);
			if(co&&'""'!=co&&""!=co&&"null"!=co)
			return GetCookieVal(j);
		}
		i = cookie.indexOf(" ", i) + 1;
		if (i == 0)
			break;
	}
	return null;
}


//获得Cookie的原始值,不存在则直接返回空字符换:''
function GetCookieDefaultEmpty(name) {
	var arg = name + "=";
	var alen = arg.length;
	var clen = document.cookie.length;
	var i = 0;
	var cookie = document.cookie;
	while (i < clen) {
		var j = i + alen;
		if (cookie.substring(i, j) == arg){ 
			var c=cookie.substring(i, j);
			var co=GetCookieVal(j);
			if(co&&'""'!=co&&""!=co&&"null"!=co)
			return GetCookieVal(j);
		}
		i = cookie.indexOf(" ", i) + 1;
		if (i == 0)
			break;
	}
	return '';
}

// 获得Cookie解码后的值
function GetCookieVal(offset) {
	var endstr = document.cookie.indexOf(";", offset);
	if (endstr == -1)
		endstr = document.cookie.length;
	var co=document.cookie.substring(offset, endstr);
	co=co.replace('\"','').replace('\"','');
	return unescape(co);
}




// 获取URL参数
function getQueryParam(name) {
	var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
	var r = window.location.search.substr(1).match(reg);
	if (r != null)
		return unescape(r[2]);
	return null;
}

//获取URL参数,默认是空的字符串
function getQueryParamDefaultEmpty(name) {
	var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
	var r = window.location.search.substr(1).match(reg);
	if (r != null)
		return unescape(r[2]);
	return '';
}

// 获取URL参数
// 得到地址栏传递参数的函数
function QueryString(qs) {
	var s = location.href;
	s = s.replace("?", "?&").split("&");
	var re = "";
	var str = "";
	for (i = 1; i < s.length; i++)
		if (s[i].indexOf(qs + "=") == 0)
			re = s[i].replace(qs + "=", "");
	re = UrlDecode(re);
	return re;
}
function QueryStringArea(qs) {
	var s = location.href;
	s = s.replace("?", "?&").split("&");
	var re = "";
	for (i = 1; i < s.length; i++)
		if (s[i].indexOf(qs + "=") == 0)
			re = s[i].replace(qs + "=", "");
	re = UrlDecode(re);
	if (re == "")
		re = 'B000000CB-全部市';
	return re;
}

// 去空格
String.prototype.trim = function() {
	return this.replace(/(^\s*)|(\s*$)/g, "");
};
function trim(str) {
	return str.replace(/^\s+|\s+$/g, "");
}

// 验证码
function changeVerifyCode(img) {
	var rand = Math.random();
	if (typeof img == 'string') {
		var imgArr = document.getElementById(img);
		imgArr.src = "/auth.cgi?" + rand;
	} else {
		img.src = "/auth.cgi?" + rand;
	}
}

// 邮箱注册
var hash = {
	'qq.com' : 'http://mail.qq.com',
	'gmail.com' : 'http://mail.google.com',
	'sina.com' : 'http://mail.sina.com.cn',
	'163.com' : 'http://mail.163.com',
	'126.com' : 'http://mail.126.com',
	'yeah.net' : 'http://www.yeah.net/',
	'sohu.com' : 'http://mail.sohu.com/',
	'tom.com' : 'http://mail.tom.com/',
	'sogou.com' : 'http://mail.sogou.com/',
	'139.com' : 'http://mail.10086.cn/',
	'hotmail.com' : 'http://www.hotmail.com',
	'live.com' : 'http://login.live.com/',
	'live.cn' : 'http://login.live.cn/',
	'live.com.cn' : 'http://login.live.com.cn',
	'189.com' : 'http://webmail16.189.cn/webmail/',
	'yahoo.com.cn' : 'http://mail.cn.yahoo.com/',
	'yahoo.cn' : 'http://mail.cn.yahoo.com/',
	'eyou.com' : 'http://www.eyou.com/',
	'21cn.com' : 'http://mail.21cn.com/',
	'188.com' : 'http://www.188.com/',
	'foxmail.coom' : 'http://www.foxmail.com',
	'wo.com.cn' : 'http://mail.wo.com.cn/mail/login.action',
	'263.net' : 'http://www.263.net/',
	'263.net.cn' : 'http://www.263.net/',
	'x263.net' : 'http://www.263.net/'
};

// 打开邮箱
function toEmail() {
	var email = $("#u_tips_info_email").children("span").first().html();
	if (email) {
		var url = email.substring(email.indexOf("@") + 1);
		if (hash[url]) {
			window.open(hash[url]);
		} else {
			window.open('http://mail.' + url);
		}
	}
}

// 清除标签class下显
function removeAtag(tag) {
	var rateWord = document.getElementById(tag);
	var childs = rateWord.childNodes;
	if (null != childs) {
		for (i = 0; i < childs.length; i++) {
			childs[i].className = "";
		}
	}
};

// 清除标签class
function removeLitag(tag) {
	$('#'+tag).find('a').removeClass('active');
};

function getStrLength(str) {
	// 获得字符串实际长度，中文2，英文1
	// str 要获得长度的字符串
	var realLength = 0, len = str.length, charCode = -1;
	for ( var i = 0; i < len; i++) {
		charCode = str.charCodeAt(i);
		if (charCode >= 0 && charCode <= 128)
			realLength += 1;
		else
			realLength += 2;
	}
	return realLength;
}

// 计时器一分钟跳转
var totleTime = 60;
var totleTimer;
function timefun() {
	totleTime = totleTime - 1;
	$("#sec_span").html(totleTime)
	if (totleTime == 0) {
		totleTime = 60;
		$("#resms_a").show();
		$("#resms_a_gray").hide();
		clearInterval(totleTimer);
	}
}

function UrlDecode(str) {
	var i, temp;
	var result = "";
	for (i = 0; i < str.length; i++) {
		if (str.charAt(i) == "%") {
			if (str.charAt(++i) == "u") {
				temp = str.charAt(i++) + str.charAt(i++) + str.charAt(i++)
						+ str.charAt(i++) + str.charAt(i);
				result += unescape("%" + temp);
			} else {
				temp = str.charAt(i++) + str.charAt(i);
				if (eval("0x" + temp) <= 160) {
					result += unescape("%" + temp);
				} else {
					temp += str.charAt(++i) + str.charAt(++i) + str.charAt(++i);
					result += Decode_unit("%" + temp);
				}
			}
		} else {
			result += str.charAt(i);
		}
	}
	return result;
}

function UrlEncode(str) {
	var i, temp, p, q;
	var result = "";
	for (i = 0; i < str.length; i++) {
		temp = str.charCodeAt(i);
		if (temp >= 0x4e00) {
			execScript("ascCode=hex(asc(\"" + str.charAt(i) + "\"))",
					"vbscript");
			result += ascCode.replace(/(.{ 2 })/g, "%$1");
		} else {
			result += escape(str.charAt(i));
		}
	}
	return result;
}


//时间格式转换
Date.prototype.format = function(format)
{
var o = {
            "M+" : this.getMonth()+1, //month
            "d+" : this.getDate(), //day
            "h+" : this.getHours(), //hour
            "m+" : this.getMinutes(), //minute
            "s+" : this.getSeconds(), //second
            "q+" : Math.floor((this.getMonth()+3)/3), //quarter
            "S" : this.getMilliseconds() //millisecond
        }
    if(/(y+)/.test(format))
    format=format.replace(RegExp.$1,(this.getFullYear()+"").substr(4 - RegExp.$1.length));
    for(var k in o)
    if(new RegExp("("+ k +")").test(format))
    format = format.replace(RegExp.$1,RegExp.$1.length==1 ? o[k] : ("00"+ o[k]).substr((""+ o[k]).length));
    return format;
}

/*
 * MAP对象，实现MAP功能
 *
 * 接口：
 * size()     获取MAP元素个数
 * isEmpty()    判断MAP是否为空
 * clear()     删除MAP所有元素
 * put(key, value)   向MAP中增加元素（key, value) 
 * remove(key)    删除指定KEY的元素，成功返回True，失败返回False
 * get(key)    获取指定KEY的元素值VALUE，失败返回NULL
 * element(index)   获取指定索引的元素（使用element.key，element.value获取KEY和VALUE），失败返回NULL
 * containsKey(key)  判断MAP中是否含有指定KEY的元素
 * containsValue(value) 判断MAP中是否含有指定VALUE的元素
 * values()    获取MAP中所有VALUE的数组（ARRAY）
 * keys()     获取MAP中所有KEY的数组（ARRAY）
 *
 * 例子：
 * var map = new Map();
 *
 * map.put("key", "value");
 * var val = map.get("key")
 * ……
 *
 */
function Map() {
    this.elements = new Array();

    //获取MAP元素个数
    this.size = function() {
        return this.elements.length;
    };

    //判断MAP是否为空
    this.isEmpty = function() {
        return (this.elements.length < 1);
    };

    //删除MAP所有元素
    this.clear = function() {
        this.elements = new Array();
    };

    //向MAP中增加元素（key, value) 
    this.put = function(_key, _value) {
        this.elements.push( {
            key : _key,
            value : _value
        });
    };

    //删除指定KEY的元素，成功返回True，失败返回False
    this.removeByKey = function(_key) {
        var bln = false;
        try {
            for (i = 0; i < this.elements.length; i++) {
                if (this.elements[i].key == _key) {
                    this.elements.splice(i, 1);
                    return true;
                }
            }
        } catch (e) {
            bln = false;
        }
        return bln;
    };
    
    //删除指定VALUE的元素，成功返回True，失败返回False
    this.removeByValue = function(_value) {//removeByValueAndKey
        var bln = false;
        try {
            for (i = 0; i < this.elements.length; i++) {
                if (this.elements[i].value == _value) {
                    this.elements.splice(i, 1);
                    return true;
                }
            }
        } catch (e) {
            bln = false;
        }
        return bln;
    };
    
    //删除指定VALUE的元素，成功返回True，失败返回False
    this.removeByValueAndKey = function(_key,_value) {
        var bln = false;
        try {
            for (i = 0; i < this.elements.length; i++) {
                if (this.elements[i].value == _value && this.elements[i].key == _key) {
                    this.elements.splice(i, 1);
                    return true;
                }
            }
        } catch (e) {
            bln = false;
        }
        return bln;
    };

    //获取指定KEY的元素值VALUE，失败返回NULL
    this.get = function(_key) {
        try {
            for (i = 0; i < this.elements.length; i++) {
                if (this.elements[i].key == _key) {
                    return this.elements[i].value;
                }
            }
        } catch (e) {
            return false;
        }
        return false;
    };

    //获取指定索引的元素（使用element.key，element.value获取KEY和VALUE），失败返回NULL
    this.element = function(_index) {
        if (_index < 0 || _index >= this.elements.length) {
            return null;
        }
        return this.elements[_index];
    };

    //判断MAP中是否含有指定KEY的元素
    this.containsKey = function(_key) {
        var bln = false;
        try {
            for (i = 0; i < this.elements.length; i++) {
                if (this.elements[i].key == _key) {
                    bln = true;
                }
            }
        } catch (e) {
            bln = false;
        }
        return bln;
    };

    //判断MAP中是否含有指定VALUE的元素
    this.containsValue = function(_value) {
        var bln = false;
        try {
            for (i = 0; i < this.elements.length; i++) {
                if (this.elements[i].value == _value) {
                    bln = true;
                }
            }
        } catch (e) {
            bln = false;
        }
        return bln;
    };
    
    //判断MAP中是否含有指定VALUE的元素
    this.containsObj = function(_key,_value) {
        var bln = false;
        try {
            for (i = 0; i < this.elements.length; i++) {
                if (this.elements[i].value == _value && this.elements[i].key == _key) {
                    bln = true;
                }
            }
        } catch (e) {
            bln = false;
        }
        return bln;
    };

    //获取MAP中所有VALUE的数组（ARRAY）
    this.values = function() {
        var arr = new Array();
        for (i = 0; i < this.elements.length; i++) {
            arr.push(this.elements[i].value);
        }
        return arr;
    };
    
    //获取MAP中所有VALUE的数组（ARRAY）
    this.valuesByKey = function(_key) {
        var arr = new Array();
        for (i = 0; i < this.elements.length; i++) {
            if (this.elements[i].key == _key) {
                arr.push(this.elements[i].value);
            }
        }
        return arr;
    };

    //获取MAP中所有KEY的数组（ARRAY）
    this.keys = function() {
        var arr = new Array();
        for (i = 0; i < this.elements.length; i++) {
            arr.push(this.elements[i].key);
        }
        return arr;
    };
    
    //获取key通过value
    this.keysByValue = function(_value) {
        var arr = new Array();
        for (i = 0; i < this.elements.length; i++) {
            if(_value == this.elements[i].value){
                arr.push(this.elements[i].key);
            }
        }
        return arr;
    };
    
    //获取MAP中所有KEY的数组（ARRAY）
    this.keysRemoveDuplicate = function() {
        var arr = new Array();
        for (i = 0; i < this.elements.length; i++) {
            var flag = true;
            for(var j=0;j<arr.length;j++){
                if(arr[j] == this.elements[i].key){
                    flag = false;
                    break;
                } 
            }
            if(flag){
                arr.push(this.elements[i].key);
            }
        }
        return arr;
    };
}


