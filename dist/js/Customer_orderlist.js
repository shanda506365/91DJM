"use strict";define(function(require,exports,module){var $=require("jquery"),Navagator=require("js/Navagator"),NavMenu=require("js/NavMenu"),Bottom=require("js/Bottom"),Toolbar=require("js/Toolbar"),Alert=require("js/Alert"),Customer_h_nav=require("js/Customer_h_nav"),Customer_orderlist=React.createClass({displayName:"Customer_orderlist",pageSize:10,pagec:null,showAlert:function(){$(this.refs.myModal).modal()},filter:function(){},ajaxPost:function(pagging,page1,total){var me=this;$.ajax({type:"POST",url:common.createUrl(me.props["data-ajax-url"]),data:{page:page1,sort:me.state.sort,filter:fid.join(",")},beforeSend:function(){$(".thumbview").loadingOverlay()},success:function(data){if($(".thumbview").loadingOverlay("remove"),data.suc){pagging.totalCount=parseInt(data.total);var nowPage=page1;me.setState({currpage:nowPage,imgList:data},function(previousState,currentProps){pagging.currPage=nowPage,pagging.InitPageController()})}else me.setState({title:"消息",message:data.msg}),me.showAlert()},error:function(XMLHttpRequest,textStatus){$(".thumbview").loadingOverlay("remove"),me.setState({title:textStatus,message:JSON.stringify(XMLHttpRequest)}),me.showAlert()},dataType:"json"})},componentDidMount:function(){var me=this,total=me.state.orderList.total;console.log(me.state.orderList),me.pagec=require("js/newPageControllPlus")({containerId:"customer_orderlist_pagging",totalCount:total,pageSize:me.pageSize,currPage:me.state.currpage,firstBtn:$("#customer_orderlist_pagging .firstBtn")[0],preBtn:$("#customer_orderlist_pagging .preBtn")[0],nextBtn:$("#customer_orderlist_pagging .nextBtn")[0],lastBtn:$("#customer_orderlist_pagging .lastBtn")[0],pageText:$("#customer_orderlist_pagging .pageText")[0],msgText:$("#customer_orderlist_pagging .msgText")[0],validateFun:!1,normalpost:!1,loadPageJson:function(page1,newurl,isSearch,okFun,errFun,validateFun){var pagging=this;me.ajaxPost(pagging,page1,total)}},$),me.pagec.InitPageController()},getInitialState:function(){var cp=$(".htmlbody").attr("data-currpage");cp=cp?parseInt($(".htmlbody").attr("data-currpage")):1;var orderList=JSON.parse($(".htmlbody").attr("data-orders"));return{title:"消息",message:"...",currpage:cp,orderList:orderList,filter:[],sort:"1"}},render:function(){var me=this,banner=JSON.parse($(".htmlbody").attr("data-banner"))[0],dataBreadcrumb=JSON.parse($(".htmlbody").attr("data-breadcrumb")),breadcrumbDom=[];$.each(dataBreadcrumb,function(index,item){var cls="";return index==dataBreadcrumb.length-1?(breadcrumbDom.push(React.createElement("li",{className:"leaf"},item.name)),!1):void breadcrumbDom.push(React.createElement("li",null,React.createElement("a",{href:item.link,className:cls},item.name)))});var tbodyDom=[],dataOrders=me.state.orderList.data;$.each(dataOrders,function(index,item){tbodyDom.push(React.createElement("tr",null,React.createElement("td",null,item.order_name),React.createElement("td",null,item.price),React.createElement("td",null,item.order_status),React.createElement("td",null,React.createElement("a",{href:"###",onClick:function(){me.viewDetail(item.order_no)}},"查看详细"))))});var dataOrderStatus=JSON.parse($(".htmlbody").attr("data-order-status")),orderStatusDom=[];return $.each(dataOrderStatus,function(index,item){0==index?orderStatusDom.push(React.createElement("option",{value:item.order_status_id,selected:"selected"},item.name)):orderStatusDom.push(React.createElement("option",{value:item.order_status_id},item.name))}),React.createElement("div",null,React.createElement(Navagator,null),React.createElement(NavMenu,{"data-index":"0"}),React.createElement("div",{className:"customer_orderlist container"},React.createElement("a",{href:banner.link},React.createElement("img",{src:banner.src,alt:"",className:"banner img-responsive"})),React.createElement("ol",{className:"breadcrumb"},breadcrumbDom),React.createElement("div",{className:"col-md-3 col-sm-12"},React.createElement(Customer_h_nav,null)),React.createElement("div",{className:"col-md-9 col-sm-12 content_right"},React.createElement("div",{className:"panel panel-default orders"},React.createElement("div",{className:"panel-heading"},"订单"),React.createElement("div",{className:"panel-body"},React.createElement("div",{className:"filter form-inline"},React.createElement("div",{className:"form-group"},React.createElement("select",{name:"order_range",onChange:me.filter,className:"form-control col-md-3"},React.createElement("option",{value:"30",selected:"selected"},"最近30天的订单"),React.createElement("option",{value:"30"},"最近7天的订单"),React.createElement("option",{value:"30"},"当天的订单")),React.createElement("select",{name:"order_status",onChange:me.filter,className:"form-control col-md-3"},orderStatusDom),React.createElement("label",{className:"col-md-6 text-right"},"共1个订单"))),React.createElement("div",{className:"table-responsive"},React.createElement("table",{className:"table"},React.createElement("thead",null,React.createElement("tr",null,React.createElement("th",null,"订单名称"),React.createElement("th",null,"订单金额(元)"),React.createElement("th",null,"订单状态"),React.createElement("th",null,"操作"))),React.createElement("tbody",null,tbodyDom))),React.createElement("div",{id:"customer_orderlist_pagging",className:"text-center"},React.createElement("div",{className:"mypagecontroller"},React.createElement("a",{className:"firstBtn",style:{cursor:"default",color:"gray"},href:"###"},"首页"),React.createElement("a",{className:"preBtn",style:{cursor:"default",color:"gray"},href:"###"},"上一页"),React.createElement("label",{className:"pageText"}),React.createElement("a",{className:"nextBtn",style:{cursor:"default",color:"gray"},href:"###"},"下一页"),React.createElement("a",{className:"lastBtn",style:{cursor:"default",color:"gray"},href:"###"},"尾页"),React.createElement("label",{className:"msgText"}))))))),React.createElement(Bottom,null),React.createElement(Toolbar,null),React.createElement("div",{className:"modal fade",ref:"myModal",tabIndex:"-1",role:"dialog"},React.createElement(Alert,{title:this.state.title,message:this.state.message})))}});$(function(){ReactDOM.render(React.createElement(Customer_orderlist,null),$(".htmlbody").get(0))})});