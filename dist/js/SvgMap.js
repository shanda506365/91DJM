"use strict";define(function(require,exports,module){require("jquery");require("lib/chinamapPath")(window),require("lib/raphael")(window);var SvgMap=React.createClass({displayName:"SvgMap",raphaelR:null,lastArea:null,lastFont:null,CreatChinaSvg:function(dom){var me=this;me.raphelR=Raphael(dom,"100%","100%"),paintMap(me.raphelR),me.raphelR.setViewBox(0,0,600,500,!1)},InitChinaSvgDataEvent:function(data,clickFun){var me=this,R=me.raphelR,fontColor="#301A8C",fontSelColor="#4B20F3",areaColor="#f05900",areaSelColor="#feab0d",textAttr={fill:fontColor,"font-size":"12px","font-family":"inherit",cursor:"pointer"};for(var state in china)!function(st,state){function contains(parentNode,childNode){return null==childNode?!0:parentNode.contains?parentNode!=childNode&&parentNode.contains(childNode):!!(16&parentNode.compareDocumentPosition(childNode))}function checkHover(e,target){return"mouseover"==getEvent(e).type?!(contains(target,getEvent(e).relatedTarget||getEvent(e).fromElement)||(getEvent(e).relatedTarget||getEvent(e).fromElement)===target):!(contains(target,getEvent(e).relatedTarget||getEvent(e).toElement)||(getEvent(e).relatedTarget||getEvent(e).toElement)===target)}function getEvent(e){return e||window.event}st.attr({cursor:"pointer"});var xx=st.getBBox().x+st.getBBox().width/2,yy=st.getBBox().y+st.getBBox().height/2;switch(china[state].name){case"江苏":xx+=5,yy-=10;break;case"河北":xx-=10,yy+=20;break;case"天津":xx+=10,yy+=10;break;case"上海":xx+=10;break;case"广东":yy-=10;break;case"澳门":yy+=10;break;case"香港":xx+=20,yy+=5;break;case"甘肃":xx-=40,yy-=30;break;case"陕西":xx+=5,yy+=10;break;case"内蒙古":xx-=15,yy+=65}"undefined"!=typeof china[state].text&&china[state].text.remove(),china[state].text=R.text(xx,yy,china[state].name).attr(textAttr),st[0].onclick=china[state].text[0].onclick=function(){me.lastArea&&(me.lastArea.animate({fill:areaColor,stroke:"#eee","stroke-width":1},1),me.lastFont.animate({"stroke-width":0},1),me.lastArea.toBack(),me.lastFont.toFront()),me.lastArea=st,me.lastFont=china[state].text,st.animate({fill:areaSelColor,stroke:"#FCFCFC","stroke-width":2},300),st.toFront(),china[state].text.animate({stroke:fontSelColor,"stroke-width":.5},100),china[state].text.toFront(),R.safari(),clickFun&&clickFun(china[state].code)},st[0].onmouseover=china[state].text[0].onmouseover=function(e){e.stopPropagation(),checkHover(e,this)&&(st.animate({"stroke-width":3},1),st.toFront(),china[state].text.toFront(),R.safari())},st[0].onmouseout=china[state].text[0].onmouseout=function(e){checkHover(e,this)&&(e.stopPropagation(),st.animate({"stroke-width":1},1),st.toBack(),china[state].text.toFront(),R.safari())}}(china[state].path,state)},componentDidMount:function(){var me=this;me.CreatChinaSvg(me.refs.svgmap),me.InitChinaSvgDataEvent({},function(code){me.props.changeProvince(code)}),window.onresize=function(){me.raphelR.setSize("100%",me.refs.svgmap.clientWidth-100)},me.raphelR.setSize("100%",me.refs.svgmap.clientWidth-100)},render:function(){return React.createElement("div",{ref:"svgmap",className:"svgmap"})}});module.exports=SvgMap});