"use strict";define(function(require,exports,module){var $=require("jquery");require("js/common");require("js/LoadMask")($);var Navagator=require("js/Navagator"),NavMenu=require("js/NavMenu"),Bottom=require("js/Bottom"),Toolbar=require("js/Toolbar"),Alert=require("js/Alert"),Customer_order_progress=React.createClass({displayName:"Customer_order_progress",showAlert:function(){$(this.refs.myModal).modal()},componentDidMount:function(){},getInitialState:function(){return{title:"消息",message:"..."}},render:function(){var dataBreadcrumb=JSON.parse($(".htmlbody").attr("data-breadcrumb")),breadcrumbDom=[];$.each(dataBreadcrumb,function(index,item){var cls="";return index==dataBreadcrumb.length-1?(breadcrumbDom.push(React.createElement("li",{className:"leaf"},item.name)),!1):void breadcrumbDom.push(React.createElement("li",null,React.createElement("a",{href:item.link,className:cls},item.name)))});var banner=JSON.parse($(".htmlbody").attr("data-banner"))[0],dataOrder=(JSON.parse($(".htmlbody").attr("data-customer")),JSON.parse($(".htmlbody").attr("data-order"))),step=0,stepArr=["glyphicon-unchecked","glyphicon-unchecked","glyphicon-unchecked","glyphicon-unchecked","glyphicon-unchecked"],proArr=["pro_un","pro_un","pro_un","pro_un","pro_un"],stepControlDom=[];if("1"==dataOrder.order_status_id){var url=$(".htmlbody").attr("data-url-earnest");stepControlDom.push(React.createElement("tr",null,React.createElement("td",null,dataOrder.order_name),React.createElement("td",null,dataOrder.price),React.createElement("td",null,dataOrder.order_status),React.createElement("td",null,React.createElement("a",{className:"btn btn-base",href:url},"支付预付款"))))}else if("2"==dataOrder.order_status_id){step=1;var url=$(".htmlbody").attr("data-url-writepayform");stepControlDom.push(React.createElement("tr",null,React.createElement("td",null,dataOrder.order_name),React.createElement("td",null,dataOrder.price),React.createElement("td",null,dataOrder.order_status),React.createElement("td",null,React.createElement("a",{className:"btn btn-base",href:url},"填写表单"))))}else if("3"==dataOrder.order_status_id||"4"==dataOrder.order_status_id||"5"==dataOrder.order_status_id){step=2;var url=$(".htmlbody").attr("data-url-paycomplition");stepControlDom.push(React.createElement("tr",null,React.createElement("td",null,dataOrder.order_name),React.createElement("td",null,dataOrder.price),React.createElement("td",null,dataOrder.order_status),React.createElement("td",null,React.createElement("a",{className:"btn btn-base",href:url},"支付尾款"))))}else if("6"==dataOrder.order_status_id||"7"==dataOrder.order_status_id||"8"==dataOrder.order_status_id){step=3;var url=$(".htmlbody").attr("data-url-viewprogress");stepControlDom.push(React.createElement("tr",null,React.createElement("td",null,dataOrder.order_name),React.createElement("td",null,dataOrder.price),React.createElement("td",null,dataOrder.order_status),React.createElement("td",null,React.createElement("a",{className:"btn btn-base",href:url},"查看施工进度"))))}else"9"==dataOrder.order_status_id&&(step=4,stepControlDom.push(React.createElement("tr",null,React.createElement("td",null,dataOrder.order_name),React.createElement("td",null,dataOrder.price),React.createElement("td",null,dataOrder.order_status),React.createElement("td",null))));for(var i=0;step>=i;i++)stepArr[i]="glyphicon-check",i>0&&(proArr[i-1]="pro");var tbodyDom=[],dataOrderHistory=JSON.parse($(".htmlbody").attr("data-order-history"));return $.each(dataOrderHistory,function(index,item){tbodyDom.push(React.createElement("tr",null,React.createElement("td",null,item.title),React.createElement("td",null,item.order_status),React.createElement("td",null,item.user_name),React.createElement("td",null,item.date_added)))}),React.createElement("div",null,React.createElement(Navagator,null),React.createElement(NavMenu,{"data-index":"0"}),React.createElement("div",{className:"customer_order_progress container"},React.createElement("a",{href:banner.link},React.createElement("img",{src:banner.src,alt:"",className:"banner img-responsive"})),React.createElement("ol",{className:"breadcrumb"},breadcrumbDom),React.createElement("div",{className:"title_progress"},React.createElement("div",{className:"order_progress"},React.createElement("div",{className:"gycon setp"},React.createElement("div",{className:proArr[0]}),React.createElement("div",{className:"glyphicon "+stepArr[0]}),React.createElement("div",null,"待付预付款")),React.createElement("div",{className:"gycon setp"},React.createElement("div",{className:proArr[1]}),React.createElement("div",{className:"glyphicon "+stepArr[1]}),React.createElement("div",null,"待填写表单")),React.createElement("div",{className:"gycon setp"},React.createElement("div",{className:proArr[2]}),React.createElement("div",{className:"glyphicon "+stepArr[2]}),React.createElement("div",null,"确认设计图")),React.createElement("div",{className:"gycon setp"},React.createElement("div",{className:proArr[3]}),React.createElement("div",{className:"glyphicon "+stepArr[3]}),React.createElement("div",null,"施工进行中")),React.createElement("div",{className:"gycon setp"},React.createElement("div",{className:"pro_un"}),React.createElement("div",{className:"glyphicon "+stepArr[4]}),React.createElement("div",null,"订单已完成"))),React.createElement("div",{className:"panel panel-default order"},React.createElement("div",{className:"panel-heading"},React.createElement("label",null,"订单详情")),React.createElement("div",{className:"panel-body"},React.createElement("div",{className:"table-responsive"},React.createElement("table",{className:"table"},React.createElement("thead",null,React.createElement("tr",null,React.createElement("th",null,"订单信息"),React.createElement("th",null,"订单金额"),React.createElement("th",null,"订单状态"),React.createElement("th",null,"操作"))),React.createElement("tbody",null,stepControlDom)))))),React.createElement("div",{className:"content"},React.createElement("div",{className:"panel panel-default history"},React.createElement("div",{className:"panel-heading"},React.createElement("label",null,"订单跟踪")),React.createElement("div",{className:"panel-body"},React.createElement("div",{className:"table-responsive"},React.createElement("table",{className:"table table-striped table-hover"},React.createElement("thead",null,React.createElement("tr",null,React.createElement("th",null,"订单操作"),React.createElement("th",null,"订单状态"),React.createElement("th",null,"操作人员"),React.createElement("th",null,"时间"))),React.createElement("tbody",null,tbodyDom))))))),React.createElement(Bottom,null),React.createElement(Toolbar,null),React.createElement("div",{className:"modal fade",ref:"myModal",tabIndex:"-1",role:"dialog"},React.createElement(Alert,{title:this.state.title,message:this.state.message})))}});$(function(){ReactDOM.render(React.createElement(Customer_order_progress,null),$(".htmlbody").get(0))})});