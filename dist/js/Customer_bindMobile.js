"use strict";define(function(require,exports,module){var $=require("jquery"),common=require("js/common");require("js/bootstrapValidator.sea")($),require("js/LoadMask")($);var Navagator=require("js/Navagator"),NavMenu=require("js/NavMenu"),Bottom=require("js/Bottom"),Toolbar=require("js/Toolbar"),Alert=require("js/Alert"),Customer_h_nav=require("js/Customer_h_nav"),Customer_editPassword=React.createClass({displayName:"Customer_editPassword",showAlert:function(){$(this.refs.myModal).modal()},componentDidMount:function(){var me=this;$(".customer_editPasswordForm").bootstrapValidator({message:common.regex.fail_text,feedbackIcons:{valid:common.feedbackIcons.valid,invalid:common.feedbackIcons.invalid,validating:common.feedbackIcons.validating}});var form=$(".customer_editPasswordForm").data("bootstrapValidator");$(".submit").click(function(){form.isValid()&&$.ajax({url:common.createUrl($(".htmlbody").attr("data-ajax-submit")),data:{},beforeSend:function(){$(".customer_editPassword").loadingOverlay()},success:function(data){$(".customer_editPassword").loadingOverlay("remove"),data.suc?(me.setState({title:"消息",message:"修改成功"}),me.showAlert()):(me.setState({title:"消息",message:data.msg}),me.showAlert())},error:function(XMLHttpRequest,textStatus){$(".customer_editPassword").loadingOverlay("remove"),me.setState({title:textStatus,message:JSON.stringify(XMLHttpRequest)}),me.showAlert()},dataType:"json"})})},getInitialState:function(){return{title:"消息",message:"..."}},render:function(){var dataBreadcrumb=JSON.parse($(".htmlbody").attr("data-breadcrumb")),breadcrumbDom=[];$.each(dataBreadcrumb,function(index,item){var cls="";return index==dataBreadcrumb.length-1?(breadcrumbDom.push(React.createElement("li",{className:"leaf"},item.name)),!1):void breadcrumbDom.push(React.createElement("li",null,React.createElement("a",{href:item.link,className:cls},item.name)))});var banner=JSON.parse($(".htmlbody").attr("data-banner"))[0];return React.createElement("div",null,React.createElement(Navagator,null),React.createElement(NavMenu,{"data-index":"0"}),React.createElement("div",{className:"customer_editPassword container"},React.createElement("a",{href:banner.link},React.createElement("img",{src:banner.src,alt:"",className:"banner img-responsive"})),React.createElement("ol",{className:"breadcrumb"},breadcrumbDom),React.createElement("div",{className:"col-md-3 col-sm-12"},React.createElement(Customer_h_nav,null)),React.createElement("div",{className:"col-md-9 col-sm-12 content_right"},React.createElement("form",{className:"customer_editPasswordForm center-block"},React.createElement("div",{className:"form-group"},React.createElement("label",null,"旧密码"),React.createElement("input",{type:"password",className:"form-control","data-bv-notempty":"true","data-bv-notempty-message":common.regex.empty_text,"data-bv-regexp":"true","data-bv-regexp-regexp":common.regex.password_partten,"data-bv-regexp-message":common.regex.password_text,name:"oldpassword",placeholder:common.regex.password_text})),React.createElement("div",{className:"form-group"},React.createElement("label",null,"新密码"),React.createElement("input",{type:"password",className:"form-control","data-bv-identical":"true","data-bv-identical-field":"confirm","data-bv-identical-message":common.regex.identical_text,"data-bv-notempty":"true","data-bv-notempty-message":common.regex.empty_text,"data-bv-regexp":"true","data-bv-regexp-regexp":common.regex.password_partten,"data-bv-regexp-message":common.regex.password_text,name:"password",placeholder:common.regex.password_text})),React.createElement("div",{className:"form-group"},React.createElement("label",null,"确认密码"),React.createElement("input",{type:"password",className:"form-control","data-bv-identical":"true","data-bv-identical-field":"password","data-bv-identical-message":common.regex.identical_text,"data-bv-notempty":"true","data-bv-notempty-message":common.regex.empty_text,"data-bv-regexp":"true","data-bv-regexp-regexp":common.regex.password_partten,"data-bv-regexp-message":common.regex.password_text,name:"confirm",placeholder:common.regex.repassword_text})),React.createElement("div",{className:"form-group"},React.createElement("button",{className:"btn btn-default submit"},"提交"))))),React.createElement(Bottom,null),React.createElement(Toolbar,null),React.createElement("div",{className:"modal fade",ref:"myModal",tabIndex:"-1",role:"dialog"},React.createElement(Alert,{title:this.state.title,message:this.state.message})))}});$(function(){ReactDOM.render(React.createElement(Customer_editPassword,null),$(".htmlbody").get(0))})});