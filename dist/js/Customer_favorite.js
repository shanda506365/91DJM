"use strict";define(function(require,exports,module){var $=require("jquery");require("js/common");require("js/LoadMask")($);var Navagator=require("js/Navagator"),NavMenu=require("js/NavMenu"),Bottom=require("js/Bottom"),Toolbar=require("js/Toolbar"),Alert=require("js/Alert"),ThumbView=require("js/ThumbView"),M_effect=require("model/M_effect"),Customer_h_nav=require("js/Customer_h_nav"),Customer_favorite=React.createClass({displayName:"Customer_favorite",pageSize:10,pagec:null,showAlert:function(){$(this.refs.myModal).modal()},componentDidMount:function(){},getInitialState:function(){return{title:"消息",message:"..."}},render:function(){var banner=JSON.parse($(".htmlbody").attr("data-banner"))[0],dataBreadcrumb=JSON.parse($(".htmlbody").attr("data-breadcrumb")),breadcrumbDom=[];$.each(dataBreadcrumb,function(index,item){var cls="";return index==dataBreadcrumb.length-1?(breadcrumbDom.push(React.createElement("li",{className:"leaf"},item.name)),!1):void breadcrumbDom.push(React.createElement("li",null,React.createElement("a",{href:item.link,className:cls},item.name)))});var thumbstrArr=JSON.parse($(".htmlbody").attr("data-imglist")),url=$(".htmlbody").attr("data-ajax-url"),categoryArr=[],thumbsUp=$(".htmlbody").attr("data-ajax-thumbsUp");return React.createElement("div",null,React.createElement(Navagator,null),React.createElement(NavMenu,{"data-index":"0"}),React.createElement("div",{className:"customer_favorite container"},React.createElement("a",{href:banner.link},React.createElement("img",{src:banner.src,alt:"",className:"banner img-responsive"})),React.createElement("ol",{className:"breadcrumb"},breadcrumbDom),React.createElement("div",{className:"col-md-3 col-sm-12"},React.createElement(Customer_h_nav,null)),React.createElement("div",{className:"col-md-9 col-sm-12 content_right"},React.createElement(ThumbView,{"data-src":thumbstrArr,"data-ajax":"true","data-model":M_effect,"data-ajax-url":url,"data-category":categoryArr,"data-ajax-thumbsUp":thumbsUp}))),React.createElement(Bottom,null),React.createElement(Toolbar,null),React.createElement("div",{className:"modal fade",ref:"myModal",tabIndex:"-1",role:"dialog"},React.createElement(Alert,{title:this.state.title,message:this.state.message})))}});$(function(){ReactDOM.render(React.createElement(Customer_favorite,null),$(".htmlbody").get(0))})});