"use strict";define(function(require,exports,module){var $=require("jquery"),Navagator=require("js/Navagator"),NavMenu=require("js/NavMenu"),BannerPlay=require("js/BannerPlay"),Line=require("js/line"),Bottom=require("js/Bottom"),Toolbar=require("js/Toolbar"),Standard=React.createClass({displayName:"Standard",render:function(){var imgArr=JSON.parse($(".htmlbody").attr("data-img")),floores=JSON.parse($(".htmlbody").attr("data-floor")),floorDom=[];return $.each(floores,function(index,item){floorDom.push(React.createElement("div",{className:"col-md-8"},React.createElement("img",{src:item.image,alt:"",className:"img-responsive"}))),floorDom.push(React.createElement("div",{className:"col-md-4 description-con"},React.createElement("div",{className:"description"},item.description),React.createElement("div",{className:"text-center"},React.createElement("button",{className:"btn btn-base doit"},"我要搭建"))))}),React.createElement("div",null,React.createElement(Navagator,null),React.createElement(NavMenu,{"data-index":"4"}),React.createElement(BannerPlay,{"data-id":"banner","data-interal":"2000","data-imgs":imgArr,"data-pagination":"true","data-npButton":"true"}),React.createElement(Line,{"data-title":"标准化套餐"}),React.createElement("div",{className:"container standard"},React.createElement("div",{className:"banner"},React.createElement("img",{className:"img-responsive",src:"images/A44.jpg",alt:""})),React.createElement("div",{className:"floor"},floorDom)),React.createElement(Bottom,null),React.createElement(Toolbar,null))}});$(function(){ReactDOM.render(React.createElement(Standard,null),$(".htmlbody").get(0))})});