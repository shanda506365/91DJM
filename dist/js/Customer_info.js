"use strict";define(function(require,exports,module){var $=require("jquery"),common=require("js/common");require("js/bootstrapValidator.sea")($),require("js/LoadMask")($);var Navagator=require("js/Navagator"),NavMenu=require("js/NavMenu"),Bottom=require("js/Bottom"),Toolbar=require("js/Toolbar"),Alert=require("js/Alert"),Customer_h_nav=require("js/Customer_h_nav"),H5FIleUpload=require("js/H5FIleUpload"),Customer_info=React.createClass({displayName:"Customer_info",showAlert:function(){$(this.refs.myModal).modal()},componentDidMount:function(){var me=this;$(".customer_infoForm").bootstrapValidator({message:common.regex.fail_text,feedbackIcons:{valid:common.feedbackIcons.valid,invalid:common.feedbackIcons.invalid,validating:common.feedbackIcons.validating}});var form=$(".customer_infoForm").data("bootstrapValidator");$(".submit").click(function(){if(0==me.state.business_licenece_image.length)return me.setState({title:"错误",message:"请上传营业执照"}),void me.showAlert();if(0==me.state.organization_code_image.length)return me.setState({title:"错误",message:"请上传组织机构代码"}),void me.showAlert();if(form.isValid()){var arr=form.$form.serializeArray();$.ajax({type:"POST",url:common.createUrl($(".htmlbody").attr("data-ajax-submit")),data:arr,beforeSend:function(){$(".customer_info").loadingOverlay()},success:function(data){$(".customer_info").loadingOverlay("remove"),data.suc?(me.setState({title:"消息",message:"修改成功"}),me.showAlert(),form.resetForm(!0)):(me.setState({title:"消息",message:data.msg}),me.showAlert())},error:function(XMLHttpRequest,textStatus){$(".customer_info").loadingOverlay("remove"),me.setState({title:textStatus,message:JSON.stringify(XMLHttpRequest)}),me.showAlert()},dataType:"json"})}})},getInitialState:function(){return{title:"消息",message:"...",headPicFile:[],business_licenece_image:[],organization_code_image:[]}},render:function(){var me=this,dataBreadcrumb=JSON.parse($(".htmlbody").attr("data-breadcrumb")),breadcrumbDom=[];$.each(dataBreadcrumb,function(index,item){var cls="";return index==dataBreadcrumb.length-1?(breadcrumbDom.push(React.createElement("li",{className:"leaf"},item.name)),!1):void breadcrumbDom.push(React.createElement("li",null,React.createElement("a",{href:item.link,className:cls},item.name)))});var banner=JSON.parse($(".htmlbody").attr("data-banner"))[0],customer=JSON.parse($(".htmlbody").attr("data-customer")),headPicFile=me.state.headPic,business_licenece_image=me.state.business_licenece_image,organization_code_image=me.state.organization_code_image;return React.createElement("div",null,React.createElement(Navagator,null),React.createElement(NavMenu,{"data-index":"0"}),React.createElement("div",{className:"customer_info container"},React.createElement("a",{href:banner.link},React.createElement("img",{src:banner.src,alt:"",className:"banner img-responsive"})),React.createElement("ol",{className:"breadcrumb"},breadcrumbDom),React.createElement("div",{className:"col-md-3 col-sm-12"},React.createElement(Customer_h_nav,null)),React.createElement("div",{className:"col-md-9 col-sm-12 content_right"},React.createElement("form",{className:"customer_infoForm form-horizontal  center-block"},React.createElement("div",{className:"form-group"},React.createElement("label",{className:"col-md-2"},"登录名："),React.createElement("span",{className:"col-md-10"},customer.mobile)),React.createElement("div",{className:"form-group"},React.createElement("label",{className:"col-md-2"},"公司名称："),React.createElement("div",{className:"col-md-10"},React.createElement("input",{type:"company_name",className:"form-control","data-bv-notempty":"true","data-bv-notempty-message":common.regex.empty_text,"data-bv-regexp":"true","data-bv-regexp-regexp":common.regex.nickname_partten,"data-bv-regexp-message":common.regex.nickname_text,name:"password",placeholder:common.regex.nickname_ph}))),React.createElement("div",{className:"form-group"},React.createElement("label",{className:"col-md-2"},"头像："),React.createElement("div",{className:"col-md-10"},React.createElement("img",{ref:"headPic",src:customer.picture,alt:""}),React.createElement("span",{className:"seltip"},"可上传 JPG,PNG,GIF"),React.createElement(H5FIleUpload,{"data-inputText":"上传头像","data-size":"2000000","data-acceptFileTypes":"images","data-count":"1","data-files":headPicFile,"data-sucFun":function(files){me.refs.headPic.src=decodeURI(files[0].url),me.setState({headPic:files})},"data-nofilesdom":"true","data-errorFun":function(msg){me.setState({title:"错误",message:msg}),me.showAlert()}}))),React.createElement("div",{className:"form-group"},React.createElement("label",{className:"col-md-2"},"邮箱："),React.createElement("div",{className:"col-md-10"},React.createElement("input",{type:"mail",className:"form-control","data-bv-notempty":"true","data-bv-notempty-message":common.regex.empty_text,"data-bv-emailaddress":"true","data-bv-emailaddress-message":common.regex.email_text,value:customer.mail,name:"email"}))),React.createElement("div",{className:"form-group"},React.createElement("label",{className:"col-md-2"},"目前所在地区"),React.createElement("div",{className:"col-md-10"},React.createElement("input",{type:"input",className:"form-control","data-bv-notempty":"true","data-bv-notempty-message":common.regex.empty_text,name:"company_name"}))),React.createElement("div",{className:"form-group"},React.createElement("label",{className:"col-md-2"},"性质："),React.createElement("div",{className:"col-md-10"},React.createElement("input",{type:"input",className:"form-control","data-bv-notempty":"true","data-bv-notempty-message":common.regex.empty_text,name:"company_name"}))),React.createElement("div",{className:"form-group"},React.createElement("label",{className:"col-md-2"},"营业执照："),React.createElement("div",{className:"col-md-10"},React.createElement("img",{ref:"business_licenece_image",src:customer.business_licenece_image,alt:"暂无"}),React.createElement("span",{className:"seltip"},"可上传 JPG,PNG,GIF"),React.createElement(H5FIleUpload,{"data-inputText":"上传营业执照","data-size":"10000000","data-acceptFileTypes":"images","data-count":"1","data-files":business_licenece_image,"data-sucFun":function(files){me.refs.business_licenece_image.src=decodeURI(files[0].url),me.setState({business_licenece_image:files})},"data-nofilesdom":"true","data-errorFun":function(msg){me.setState({title:"错误",message:msg}),me.showAlert()}}))),React.createElement("div",{className:"form-group"},React.createElement("label",{className:"col-md-2"},"组织机构代码："),React.createElement("div",{className:"col-md-10"},React.createElement("img",{ref:"organization_code_image",src:customer.organization_code_image,alt:"暂无"}),React.createElement("span",{className:"seltip"},"可上传 JPG,PNG,GIF"),React.createElement(H5FIleUpload,{"data-inputText":"上传组织机构代码","data-size":"10000000","data-acceptFileTypes":"images","data-count":"1","data-files":organization_code_image,"data-sucFun":function(files){me.refs.organization_code_image.src=decodeURI(files[0].url),me.setState({organization_code_image:files})},"data-nofilesdom":"true","data-errorFun":function(msg){me.setState({title:"错误",message:msg}),me.showAlert()}}))),React.createElement("div",{className:"form-group"},React.createElement("button",{className:"btn btn-default submit"},"保存"))))),React.createElement(Bottom,null),React.createElement(Toolbar,null),React.createElement("div",{className:"modal fade",ref:"myModal",tabIndex:"-1",role:"dialog"},React.createElement(Alert,{title:this.state.title,message:this.state.message})))}});$(function(){ReactDOM.render(React.createElement(Customer_info,null),$(".htmlbody").get(0))})});