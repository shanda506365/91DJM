"use strict";define(function(require,exports,module){var $=require("jquery");require("lib/bootstrap.min")($);var Navagator=require("js/Navagator"),NavMenu=require("js/NavMenu"),Bottom=require("js/Bottom"),Toolbar=require("js/Toolbar"),Standard_detail=React.createClass({displayName:"Standard_detail",componentDidMount:function(){var dataDetail=JSON.parse($(".htmlbody").attr("data-detail"));$(this.refs.content).html(dataDetail.description)},render:function(){var dataLinkSubmit=($(".htmlbody").attr("data-floor-1"),$(".htmlbody").attr("data-floor-2"),$(".htmlbody").attr("data-link-submit")),dataBreadcrumb=JSON.parse($(".htmlbody").attr("data-breadcrumb")),breadcrumbDom=[];$.each(dataBreadcrumb,function(index,item){var cls="";return index==dataBreadcrumb.length-1?(breadcrumbDom.push(React.createElement("li",{className:"leaf"},item.name)),!1):void breadcrumbDom.push(React.createElement("li",null,React.createElement("a",{href:item.link,className:cls},item.name)))});var dataDetail=JSON.parse($(".htmlbody").attr("data-detail")),imgDom=[];return $.each(dataDetail.images,function(index,url){imgDom.push(React.createElement("div",{className:"imgs"},React.createElement("img",{className:"img-responsive",src:url,alt:""})))}),React.createElement("div",null,React.createElement(Navagator,null),React.createElement(NavMenu,{"data-index":"4"}),React.createElement("div",{className:"container standard_detail"},React.createElement("img",{src:"images/A41.jpg",alt:"",className:"banner img-responsive"}),React.createElement("ol",{className:"breadcrumb"},breadcrumbDom),React.createElement("div",{className:"floor"},React.createElement("div",{className:"row"},React.createElement("div",{className:"col-md-8"},React.createElement("img",{src:dataDetail.image,alt:"",className:"img-responsive"})),React.createElement("div",{className:"col-md-4 description"},React.createElement("div",{className:"title"},React.createElement("img",{src:dataDetail.designer_image,alt:""}),React.createElement("span",{className:"font"},dataDetail.title)),React.createElement("div",{className:"content"},React.createElement("ul",{className:"nav nav-tabs",role:"tablist"},React.createElement("li",{role:"presentation",className:"active"},React.createElement("a",{href:"#design_des","aria-controls":"design_des",role:"tab","data-toggle":"tab"},"设计说明")),React.createElement("li",{role:"presentation"},React.createElement("a",{href:"#designer_des","aria-controls":"designer_des",role:"tab","data-toggle":"tab"},"设计师介绍"))),React.createElement("div",{className:"tab-content"},React.createElement("div",{role:"tabpanel",className:"tab-pane active",id:"design_des"},dataDetail.summary),React.createElement("div",{role:"tabpanel",className:"tab-pane",id:"designer_des"},dataDetail.designer_name,dataDetail.designer_description))),React.createElement("div",{className:"text-center"},React.createElement("a",{href:dataLinkSubmit,className:"btn btn-base doit"},"我要搭建"))))),React.createElement("div",{className:"clearfix"}),React.createElement("div",{className:"detail"},React.createElement("div",{className:"title"},"简介"),React.createElement("div",{className:"content"},"参考价格"),React.createElement("div",{className:"title"},"详情"),React.createElement("div",{ref:"content",className:"content"}),imgDom)),React.createElement(Bottom,null),React.createElement(Toolbar,null))}});$(function(){ReactDOM.render(React.createElement(Standard_detail,null),$(".htmlbody").get(0))})});