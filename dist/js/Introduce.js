"use strict";define(function(require,exports,module){var $=require("jquery"),Navagator=require("js/Navagator"),NavMenu=require("js/NavMenu"),BannerPlay=require("js/BannerPlay"),Line=require("js/line"),Bottom=require("js/Bottom"),Toolbar=require("js/Toolbar"),Introduce=React.createClass({displayName:"Introduce",render:function(){var imgArr=JSON.parse($(".htmlbody").attr("data-img")),dataContent=$(".htmlbody").attr("data-content");return React.createElement("div",null,React.createElement(Navagator,null),React.createElement(NavMenu,{"data-index":"1"}),React.createElement(BannerPlay,{"data-id":"banner","data-interal":"2000","data-imgs":imgArr,"data-pagination":"true","data-npButton":"true"}),React.createElement(Line,{"data-title":"平台介绍"}),React.createElement("div",{className:"container introduce"},React.createElement("img",{className:"img-responsive",src:dataContent,alt:""})),React.createElement(Bottom,null),React.createElement(Toolbar,null))}});$(function(){ReactDOM.render(React.createElement(Introduce,null),$(".htmlbody").get(0))})});