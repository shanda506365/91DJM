"use strict";define(function(require,exports,module){var $=require("jquery"),Navagator=require("js/Navagator"),NavMenu=require("js/NavMenu"),BannerPlay=require("js/BannerPlay"),Line=require("js/line"),Bottom=require("js/Bottom"),Toolbar=require("js/Toolbar"),ThumbView=require("js/ThumbView"),M_effect=require("model/M_effect"),Effect=React.createClass({displayName:"Effect",render:function(){var thumbstrArr=JSON.parse($(".htmlbody").attr("data-imglist")),imgArr=JSON.parse($(".htmlbody").attr("data-img")),url=$(".htmlbody").attr("data-ajax-url"),categoryArr=JSON.parse($(".htmlbody").attr("data-category")),thumbsUp=$(".htmlbody").attr("data-ajax-thumbsUp");return React.createElement("div",null,React.createElement(Navagator,null),React.createElement(NavMenu,{"data-index":"2"}),React.createElement(BannerPlay,{"data-id":"banner","data-interal":"2000","data-imgs":imgArr,"data-pagination":"true","data-npButton":"true"}),React.createElement(Line,{"data-title":"案例展示"}),React.createElement("div",{className:"effect container"},React.createElement(ThumbView,{"data-src":thumbstrArr,"data-ajax":"true","data-model":M_effect,"data-ajax-url":url,"data-category":categoryArr,"data-sort":"true","data-ajax-thumbsUp":thumbsUp})),React.createElement(Bottom,null),React.createElement(Toolbar,null))}});$(function(){ReactDOM.render(React.createElement(Effect,null),$(".htmlbody").get(0))})});