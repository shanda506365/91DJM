"use strict";define(function(require,exports,module){require("lib/chinamapPath"),require("lib/raphael");React.createClass({displayName:"SvgMap",raphaelR:null,CreatChinaSvg:function(dom){var me=this;me.raphelR=Raphael(dom,800,700),paintMap(me.raphelR),me.raphelR.setViewBox(0,0,600,500,!1)},InitChinaSvgDataEvent:function(data,clickFun){var me=this,R=me.raphelR,textAttr={fill:"#000","font-size":"12px",cursor:"pointer"};for(var state in china)china[state].path.color=Raphael.getColor(.9),function(st,state){st.attr({cursor:"pointer"});var xx=st.getBBox().x+st.getBBox().width/2,yy=st.getBBox().y+st.getBBox().height/2;switch(china[state].name){case"江苏":xx+=5,yy-=10;break;case"河北":xx-=10,yy+=20;break;case"天津":xx+=10,yy+=10;break;case"上海":xx+=10;break;case"广东":yy-=10;break;case"澳门":yy+=10;break;case"香港":xx+=20,yy+=5;break;case"甘肃":xx-=40,yy-=30;break;case"陕西":xx+=5,yy+=10;break;case"内蒙古":xx-=15,yy+=65}var val="0";Ext.Array.each(data,function(item,index,alls){item.province_code==china[state].code&&(val=item.count)}),"undefined"!=typeof china[state].text&&china[state].text.remove(),china[state].text=R.text(xx,yy,china[state].name+"("+val+")").attr(textAttr),st[0].onclick=china[state].text[0].onclick=function(){clickFun&&clickFun(china[state].code)},st[0].onmouseover=china[state].text[0].onmouseover=function(){st.animate({fill:st.color,stroke:"#04937D","stroke-width":2},500),st.toFront(),china[state].text.toFront(),R.safari()},st[0].onmouseout=china[state].text[0].onmouseout=function(){st.animate({fill:"#97d6f5",stroke:"#eee","stroke-width":1},500),st.toBack(),china[state].text.toFront(),R.safari()}}(china[state].path,state)},compountDidMount:function(){var me=this;me.CreatChinaSvg(this.refs.svgmap),me.InitChinaSvgDataEvent({},function(code){console.log(code)})},getInitialState:function(){},render:function(){return React.createElement("div",{ref:"svgmap",className:"svgmap"})}})});