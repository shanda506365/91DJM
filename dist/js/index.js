"use strict";define(function(require,exports,module){var $=require("jquery"),BannerPlay=(require("lib/jquery.easing.min"),require("js/BannerPlay")),Navagator=(require("js/common"),require("js/Navagator")),NavMenu=require("js/NavMenu"),Line=require("js/line"),ThumbView=require("js/ThumbView"),Bottom=require("js/Bottom"),Toolbar=require("js/Toolbar"),Index=React.createClass({displayName:"Index",componentDidMount:function(){},render:function(){var imgArr=JSON.parse($(".htmlbody").attr("data-img")),floor1Arr=JSON.parse($(".htmlbody").attr("data-floor1")),floor1_r=JSON.parse($(".htmlbody").attr("data-floor1-r")),floor2=JSON.parse($(".htmlbody").attr("data-floor2"))[0],floor2_r=JSON.parse($(".htmlbody").attr("data-floor2-r"))[0],thumbstrArr=JSON.parse($(".htmlbody").attr("data-thumbview"));return React.createElement("div",null,React.createElement(Navagator,null),React.createElement(NavMenu,null),React.createElement(BannerPlay,{"data-id":"banner","data-interal":"2000","data-imgs":imgArr,"data-pagination":"true","data-npButton":"true"}),React.createElement("div",{className:"container slogan"},React.createElement("div",{className:"col-md-12 text-center"},React.createElement("a",null,React.createElement("h2",null,"服务保障 极致服务 >>"))),React.createElement("div",{className:"col-md-12"},React.createElement("img",{className:"img-responsive",src:"images/A08.jpg",alt:""}))),React.createElement(Line,{"data-title":"标准化套餐"}),React.createElement("div",{className:"floor11 container"},React.createElement("div",{className:"floor1d"},React.createElement(BannerPlay,{"data-id":"floor1","data-interal":"5000","data-imgs":floor1Arr,"data-pagination":"true","data-npButton":"true"}),React.createElement("div",{className:"floor1-r"},React.createElement("img",{className:"center-block",src:floor1_r[0].src,alt:""}),React.createElement("a",{href:"###",className:"btn btn-base floor1-btn-make"},"我要搭建")))),React.createElement(Line,{"data-title":"个性化定制"}),React.createElement("div",{className:"container floor2",style:{marginTop:"20px"}},React.createElement("div",{style:{width:"60.5%","float":"left",maxWidth:"705px",position:"relative"}},React.createElement("img",{className:"img-responsive",src:floor2.src,alt:""}),React.createElement("a",{href:"###",className:"btn btn-base floor2-btn-make"},"我要定制")),React.createElement("img",{className:"img-responsive",style:{width:"39.5%","float":"left",maxWidth:"475px"},src:floor2_r.src,alt:""})),React.createElement(Line,{"data-title":"案例展示"}),React.createElement(ThumbView,{"data-src":thumbstrArr}),React.createElement("div",{className:"viewMore"},React.createElement("div",{className:"text-center"},React.createElement("a",{href:"###",className:"btn btn-default btn-viewMore",role:"button"},"更 多 案 例 >>"))),React.createElement(Bottom,null),React.createElement(Toolbar,null))}});$(function(){ReactDOM.render(React.createElement(Index,null),$(".htmlbody").get(0))})});