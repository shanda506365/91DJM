"use strict";define(function(require,exports,module){var $=require("jquery");require("js/common");require("js/LoadMask")($);var Navagator=require("js/Navagator"),NavMenu=require("js/NavMenu"),Bottom=require("js/Bottom"),Toolbar=require("js/Toolbar"),Customer_home=React.createClass({displayName:"Customer_home",componentDidMount:function(){},getInitailState:function(){},render:function(){var dataBreadcrumb=JSON.parse($(".htmlbody").attr("data-breadcrumb")),breadcrumbDom=[];$.each(dataBreadcrumb,function(index,item){var cls="";return index==dataBreadcrumb.length-1?(breadcrumbDom.push(React.createElement("li",{className:"leaf"},item.name)),!1):void breadcrumbDom.push(React.createElement("li",null,React.createElement("a",{href:item.link,className:cls},item.name)))});var banner=JSON.parse($(".htmlbody").attr("data-banner"))[0];return React.createElement("div",null,React.createElement(Navagator,null),React.createElement(NavMenu,{"data-index":"0"}),React.createElement("div",{className:"customer_home container"},React.createElement("a",{href:banner.link},React.createElement("img",{src:banner.src,alt:"",className:"banner img-responsive"})),React.createElement("ol",{className:"breadcrumb"},breadcrumbDom),React.createElement("div",{className:"col-md-3 col-sm-12"},React.createElement("ul",{className:"nav nav-pills nav-stacked"},React.createElement("li",{className:"title"},React.createElement("span",{className:"glyphicon glyphicon-user"}),"个人中心"),React.createElement("li",null,React.createElement("a",{href:"#"},"个人信息")),React.createElement("li",null,React.createElement("a",{href:"#"},"修改密码")),React.createElement("li",null,React.createElement("a",{href:"#"},"邮箱绑定")),React.createElement("li",null,React.createElement("a",{href:"#"},"手机绑定")),React.createElement("div",{className:"clearfix"}),React.createElement("li",{className:"title"},React.createElement("span",{className:"glyphicon glyphicon-list-alt"}),"订单中心"),React.createElement("li",null,React.createElement("a",{href:"#"},"我的订单")),React.createElement("li",null,React.createElement("a",{href:"#"},"我的表单")),React.createElement("li",null,React.createElement("a",{href:"#"},"我的收藏")),React.createElement("div",{className:"clearfix"}),React.createElement("li",{className:"title"},React.createElement("span",{className:"glyphicon glyphicon-tree-deciduous"}),"设计作品"),React.createElement("li",null,React.createElement("a",{href:"#"},"我的作品")),React.createElement("li",null,React.createElement("a",{href:"#"},"上传作品")))),React.createElement("div",{className:"col-md-9 col-sm-12"},React.createElement("div",{className:"table-responsive"},React.createElement("table",{className:"table"},React.createElement("thead",null,React.createElement("tr",null,React.createElement("th",null,"#"),React.createElement("th",null,"Table heading"),React.createElement("th",null,"Table heading"),React.createElement("th",null,"Table heading"),React.createElement("th",null,"Table heading"),React.createElement("th",null,"Table heading"),React.createElement("th",null,"Table heading"))),React.createElement("tbody",null,React.createElement("tr",null,React.createElement("th",{scope:"row"},"1"),React.createElement("td",null,"Table cell"),React.createElement("td",null,"Table cell"),React.createElement("td",null,"Table cell"),React.createElement("td",null,"Table cell"),React.createElement("td",null,"Table cell"),React.createElement("td",null,"Table cell")),React.createElement("tr",null,React.createElement("th",{scope:"row"},"2"),React.createElement("td",null,"Table cell"),React.createElement("td",null,"Table cell"),React.createElement("td",null,"Table cell"),React.createElement("td",null,"Table cell"),React.createElement("td",null,"Table cell"),React.createElement("td",null,"Table cell")),React.createElement("tr",null,React.createElement("th",{scope:"row"},"3"),React.createElement("td",null,"Table cell"),React.createElement("td",null,"Table cell"),React.createElement("td",null,"Table cell"),React.createElement("td",null,"Table cell"),React.createElement("td",null,"Table cell"),React.createElement("td",null,"Table cell"))))))),React.createElement(Bottom,null),React.createElement(Toolbar,null))}});$(function(){ReactDOM.render(React.createElement(Customer_home,null),$(".htmlbody").get(0))})});