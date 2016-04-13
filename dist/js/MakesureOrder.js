"use strict";define(function(require,exports,module){var $=require("jquery");require("js/LoadMask")($);var common=require("js/common"),Navagator=require("js/Navagator"),NavMenu=require("js/NavMenu"),Bottom=require("js/Bottom"),Toolbar=require("js/Toolbar"),Alert=require("js/Alert"),MakesureOrder=React.createClass({displayName:"MakesureOrder",showAlert:function(){$(this.refs.myModal).modal()},back:function(){window.location.href=$(".htmlbody").attr("data-url-back")},submit:function(){var me=this,form=$(".writepayformForm").data("bootstrapValidator");if(form.isValid()){var arr=form.$form.serializeArray();$.ajax({type:"POST",url:common.createUrl($(".htmlbody").attr("data-ajax-submit")),data:arr,beforeSend:function(){$(".writepayform").loadingOverlay()},success:function(data){$(".writepayform").loadingOverlay("remove"),data.success?window.location.href="makesureOrder.html":(me.setState({title:"错误",message:data.msg}),me.showAlert())},error:function(XMLHttpRequest,textStatus){$(".writepayform").loadingOverlay("remove"),me.setState({title:textStatus,message:JSON.stringify(XMLHttpRequest)}),me.showAlert()},dataType:"json"})}},componentDidMount:function(){var me=this;if(me.state.dataOrder&&""!=me.state.dataOrder)for(var key in me.state.dataOrder)"files"==name||$("[name="+key+"]").text(me.state.dataOrder[key])},getInitialState:function(){var dataOrderNum=$(".htmlbody").attr("data-orderNum"),dataOrder=JSON.parse($(".htmlbody").attr("data-order"));return{title:"消息",message:"...",dataOrderNum:dataOrderNum,dataOrder:dataOrder}},render:function(){var me=this,dataBreadcrumb=JSON.parse($(".htmlbody").attr("data-breadcrumb")),breadcrumbDom=[];$.each(dataBreadcrumb,function(index,item){var cls="";return index==dataBreadcrumb.length-1?(breadcrumbDom.push(React.createElement("li",{className:"leaf"},item.name)),!1):void breadcrumbDom.push(React.createElement("li",null,React.createElement("a",{href:item.link,className:cls},item.name)))});var filesDom=[];return me.state.dataOrder&&""!=me.state.dataOrder&&$.each(me.state.dataOrder.files,function(index,file){filesDom.push(React.createElement("div",null,React.createElement("span",{className:"glyphicon glyphicon-paperclip"})," ",file.name,"  (",file.size,")"))}),React.createElement("div",null,React.createElement(Navagator,null),React.createElement(NavMenu,{"data-index":"4"}),React.createElement("div",{className:"success text-center hidden"},"订单表单已经生成完毕，请等待设计师制作设计图。"),React.createElement("div",{className:"container makesureOrder"},React.createElement("ol",{className:"breadcrumb"},breadcrumbDom),React.createElement("div",{className:"noti"},"本项目提供一次设计图免费修改服务，且仅限于颜色、开口方向、画面方位的修改，不涉及整体造型、材质、物料增加的修改。"),React.createElement("div",{className:"title"},"展台搭建详细表单"),React.createElement("form",{className:"makesureOrderForm form-horizontal"},React.createElement("div",{className:"form-group"},React.createElement("label",{className:"col-md-2"},"参加展会的主题名称："),React.createElement("div",{className:"col-md-10"},React.createElement("label",{name:"exhibition_subject text"}," "))),React.createElement("div",{className:"form-group"},React.createElement("label",{className:"col-md-2"},"尺寸："),React.createElement("div",{className:"col-md-10"},React.createElement("label",{name:"length text"}," "),"x",React.createElement("label",{name:"width text"}," "),"x",React.createElement("label",{name:"height text"}," "))),React.createElement("div",{className:"form-group"},React.createElement("label",{className:"col-md-2"},"面积："),React.createElement("div",{className:"col-md-10"},React.createElement("label",{name:"area text"}," "))),React.createElement("div",{className:"form-group"},React.createElement("label",{className:"col-md-2"},"是否异形："),React.createElement("div",{className:"col-md-10"},React.createElement("label",{name:"is_squareness text"}," "))),React.createElement("div",{className:"form-group"},React.createElement("label",{className:"col-md-2"},"报馆审批的时间："),React.createElement("div",{className:"col-md-10"},React.createElement("label",{name:"exhibition_verify_date text"}," "))),React.createElement("div",{className:"form-group"},React.createElement("label",{className:"col-md-2"},"进场搭建的时间："),React.createElement("div",{className:"col-md-10"},React.createElement("label",{name:"exhibition_enter_date text"}," "))),React.createElement("div",{className:"form-group"},React.createElement("label",{className:"col-md-2"},"展会开幕的时间："),React.createElement("div",{className:"col-md-10"},React.createElement("label",{name:"exhibition_begin_date text"}," "))),React.createElement("div",{className:"form-group"},React.createElement("label",{className:"col-md-2"},"撤展结束的时间："),React.createElement("div",{className:"col-md-10"},React.createElement("label",{name:"exhibition_leave_date text"}," "))),React.createElement("div",{className:"form-group"},React.createElement("label",{className:"col-md-2"},"备注说明："),React.createElement("div",{className:"col-md-10"},React.createElement("div",{className:"remark",name:"remark"}," "))),React.createElement("div",{className:"form-group"},React.createElement("label",{className:"col-md-2"},"上传重要资料："),React.createElement("div",{className:"col-md-10"},filesDom)),React.createElement("div",{className:"row text-center"},React.createElement("button",{className:"btn btn-base btn-back",onClick:me.back},"返回修改"),React.createElement("button",{className:"btn btn-base btn-submit",onClick:me.submit},"确认提交")))),React.createElement(Bottom,null),React.createElement(Toolbar,null),React.createElement("div",{className:"modal fade",ref:"myModal",tabIndex:"-1",role:"dialog"},React.createElement(Alert,{title:this.state.title,message:this.state.message})))}});$(function(){ReactDOM.render(React.createElement(MakesureOrder,null),$(".htmlbody").get(0))})});