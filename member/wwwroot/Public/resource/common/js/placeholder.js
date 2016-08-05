// JavaScript Document

    /**
     * @name placeHolder
     * @class 跨浏览器placeHolder,对于不支持原生placeHolder的浏览器，通过value或插入span元素两种方案模拟
     * @param {Object} obj 要应用placeHolder的表单元素对象
     * @param {Boolean} span 是否采用悬浮的span元素方式来模拟placeHolder，默认值false,默认使用value方式模拟
     */

    function placeHolder(obj) {
        if (!obj.getAttribute('placeholder')) return;
        var supportPlaceholder = 'placeholder' in document.createElement('input');
        if (!supportPlaceholder) {
            var defaultValue = obj.getAttribute('placeholder');
                var placeHolderCont = document.createTextNode(defaultValue);				
                var oWrapper = document.createElement('span');
                oWrapper.style.cssText = 'position:absolute; color:#999; display:inline-block; overflow:hidden;';
                oWrapper.className = 'wrap-placeholder';
                oWrapper.style.fontFamily = getStyle(obj, 'fontFamily');
                oWrapper.style.fontSize = getStyle(obj, 'fontSize');
                oWrapper.style.marginLeft = parseInt(getStyle(obj, 'marginLeft')) ? parseInt(getStyle(obj, 'marginLeft')) + 3 + 'px' : 3 + 'px';
                oWrapper.style.marginTop = parseInt(getStyle(obj, 'marginTop')) ? getStyle(obj, 'marginTop'): 1 + 'px';
                oWrapper.style.paddingLeft = getStyle(obj, 'paddingLeft');
				oWrapper.style.paddingTop = getStyle(obj, 'paddingTop');
                //oWrapper.style.width = obj.offsetWidth - parseInt(getStyle(obj, 'marginLeft')) + 'px';
                //oWrapper.style.height = obj.offsetHeight + 'px';
                //oWrapper.style.lineHeight = obj.nodeName.toLowerCase()=='textarea'? '':obj.offsetHeight + 'px';
				oWrapper.style.width = getStyle(obj, 'width');
				oWrapper.style.height = getStyle(obj, 'height');
				oWrapper.style.lineHeight = getStyle(obj, 'lineHeight');							
                oWrapper.appendChild(placeHolderCont);	
				//判断是否需要插入span
				var spanwrap=obj.parentNode.getElementsByTagName('span');	
				var spannum=spanwrap.length;
				var m=0;
				if(spannum!=0){
					for(var k=0;k<spannum;k++){
						if(spanwrap[k].className == 'wrap-placeholder'){
							m=1;
							var alreadyspan=spanwrap[k];
						}
					}
				}
				if(m==0){
					obj.parentNode.insertBefore(oWrapper, obj);
				}else{
					oWrapper=alreadyspan;
				}
				//点击span，获得焦点
                oWrapper.onclick = function () {
                    obj.focus();
                }
				//绑定input、keyup或onpropertychange事件
                obj.onpropertychange = changeHandler;
				if (obj.addEventListener&&typeof(obj.onkeyup)=='object') {
                    obj.addEventListener("keyup", changeHandler, false);
                }
				//if (typeof(obj.oninput)=='object') {
                    //obj.addEventListener("input", changeHandler, false);
                //}
                function changeHandler() {
                    oWrapper.style.display = obj.value != '' ? 'none' : 'inline-block';
                }
				
                /**
                 * @name getStyle
                 * @class 获取样式
                 * @param {Object} obj 要获取样式的对象
                 * @param {String} styleName 要获取的样式名
                 */
                function getStyle(obj, styleName) {
                    var oStyle = null;
                    if (obj.currentStyle)
                        oStyle = obj.currentStyle[styleName];
                    else if (window.getComputedStyle)
                        oStyle = window.getComputedStyle(obj, null)[styleName];
                    return oStyle;
                }
        }
    }
	function placeholderinit(){
		var inpColl = document.getElementsByTagName('input'),
			textColl = document.getElementsByTagName('textarea');
		//html集合转化为数组 
		function toArray(coll) {
		  for (var i = 0,
		  a = [], len = coll.length; i < len; i++) {
			a[i] = coll[i];
		  }
		  return a;
		}
		var inpArr = toArray(inpColl),
		textArr = toArray(textColl),
		placeholderArr = inpArr.concat(textArr);
		for (var i = 0; i < placeholderArr.length; i++) {
		  if (placeholderArr[i].getAttribute('placeholder')) {
			placeHolder(placeholderArr[i]);
		  }
		}
	}
	placeholderinit();

	
	

