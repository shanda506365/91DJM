"use strict";define(function(require,exports,module){var $=require("jquery");require("lib/bootstrap.min")($),require("js/bootstrapValidator.sea")($),require("js/LoadMask")($);var common=require("js/common"),Navagator=require("js/Navagator"),NavMenu=require("js/NavMenu"),Bottom=require("js/Bottom"),Toolbar=require("js/Toolbar"),Alert=require("js/Alert");require("lib/bootstrap-datepicker")($,void 0),require("lib/locales/bootstrap-datepicker.zh-CN")($),require("lib/chinamapPath")(window);var H5FIleUpload=require("js/H5FIleUpload"),Writepayform=React.createClass({displayName:"Writepayform",showAlert:function(){$(this.refs.myModal).modal()},reset:function(){var form=$(".writepayformForm").data("bootstrapValidator");form.resetForm()},submit:function(){var form=$(".writepayformForm").data("bootstrapValidator");if(form.isValid()){var arr=form.$form.serializeArray();$.ajax({type:"POST",url:common.createUrl($(".htmlbody").attr("data-ajax-submit")),data:arr,beforeSend:function(){$(".submit").loadingOverlay()},success:function(data){$(".submit").loadingOverlay("remove"),data.success?window.location.href="/writepayfrom.html":(me.setState({title:"错误",message:data.msg}),me.showAlert())},error:function(XMLHttpRequest,textStatus){$(".submit").loadingOverlay("remove"),me.setState({title:textStatus,message:JSON.stringify(XMLHttpRequest)}),me.showAlert()},dataType:"json"})}},componentDidMount:function(){$('span[data-toggle="tooltip"]').tooltip(),$(".form_datetime").datepicker({todayBtn:!0,language:"zh-CN",autoclose:!0}),$(".writepayformForm").bootstrapValidator({message:common.regex.fail_text,feedbackIcons:{valid:common.feedbackIcons.valid,invalid:common.feedbackIcons.invalid,validating:common.feedbackIcons.validating}})},getInitialState:function(){return{title:"消息",message:"..."}},render:function(){var me=this,fileUploadExDom=[];fileUploadExDom.push(React.createElement("div",{className:"inline-block fileUploadExDom"},React.createElement("div",{className:"inline-block control-tip"},"哪些是重要资料"),React.createElement("div",{className:"inline-block"},React.createElement("span",{className:"glyphicon glyphicon-question-sign question","data-toggle":"tooltip","data-placement":"bottom",title:"重要资料包括：展场平面图、CAD图、现场照片、企业资料、logo等有助于设计师修改效果图的文件。"}))));var dataBreadcrumb=JSON.parse($(".htmlbody").attr("data-breadcrumb")),breadcrumbDom=[];return $.each(dataBreadcrumb,function(index,item){var cls="";return index==dataBreadcrumb.length-1?(breadcrumbDom.push(React.createElement("li",{className:"leaf"},item.name)),!1):void breadcrumbDom.push(React.createElement("li",null,React.createElement("a",{href:item.link,className:cls},item.name)))}),React.createElement("div",null,React.createElement(Navagator,null),React.createElement(NavMenu,{"data-index":"4"}),React.createElement("div",{className:"container writepayform"},React.createElement("ol",{className:"breadcrumb"},breadcrumbDom),React.createElement("div",{className:"noti"},"本项目提供一次设计图免费修改服务，且仅限于颜色、开口方向、画面方位的修改，不涉及整体造型、材质、物料增加的修改。"),React.createElement("div",{className:"title"},"展台搭建详细表单"),React.createElement("form",{className:"writepayformForm form-horizontal"},React.createElement("div",{className:"form-group"},React.createElement("label",{className:"col-md-2"},"参加展会的主题名称："),React.createElement("div",{className:"col-md-10"},React.createElement("input",{name:"exhibition_subject",type:"text",className:"form-control",placeholder:'展会名称如"第46届成都市房地产交易会(2015秋季)"',"data-bv-notempty":"true","data-bv-notempty-message":common.regex.empty_text}))),React.createElement("div",{className:"form-group"},React.createElement("label",{className:"col-md-2"},"尺寸："),React.createElement("div",{className:"col-md-2 size"},React.createElement("input",{name:"length",type:"text",className:"form-control inline-block",placeholder:"长","data-bv-notempty":"true","data-bv-notempty-message":common.regex.empty_text})),React.createElement("div",{className:"col05 col-sm-12 col-xs-12"},React.createElement("div",{className:"glyphicon glyphicon-remove"})),React.createElement("div",{className:"col-md-2 size"},React.createElement("input",{name:"width",type:"text",className:"form-control inline-block",placeholder:"宽","data-bv-notempty":"true","data-bv-notempty-message":common.regex.empty_text})),React.createElement("div",{className:"col05 col-sm-12 col-xs-12"},React.createElement("div",{className:"glyphicon glyphicon-remove"})),React.createElement("div",{className:"col-md-2 size"},React.createElement("input",{name:"height",type:"text",className:"form-control inline-block",placeholder:"限高","data-bv-notempty":"true","data-bv-notempty-message":common.regex.empty_text})),React.createElement("div",{className:"col-md-2 size"},React.createElement("div",{className:"inline-block control-tip"},'默认单位为"米"'))),React.createElement("div",{className:"form-group"},React.createElement("label",{className:"col-md-2"},"面积："),React.createElement("div",{className:"col-md-6 area"},React.createElement("input",{name:"area",type:"text",className:"form-control","data-bv-notempty":"true","data-bv-notempty-message":common.regex.empty_text})),React.createElement("div",{className:"col-md-4"},React.createElement("div",{className:"inline-block control-tip"},"允许面积差异化不超过10%"),React.createElement("div",{className:"inline-block"},React.createElement("span",{className:"glyphicon glyphicon-question-sign question","data-toggle":"tooltip","data-placement":"bottom",title:"当您选择相应的方案时，允许与您的实际展台面积有所差异，但最大不超过方案面积的10%"})),React.createElement("div",{className:"inline-block control-tip"},'默认单位为"米"'))),React.createElement("div",{className:"form-group"},React.createElement("label",{className:"col-md-2"},"是否异形："),React.createElement("div",{className:"col-md-10"},React.createElement("div",{className:"radio-inline"},React.createElement("label",null,React.createElement("input",{type:"radio",name:"is_squareness",value:"0"}),"是")),React.createElement("div",{className:"radio-inline"},React.createElement("label",null,React.createElement("input",{type:"radio",name:"is_squareness",value:"1",checked:!0}),"否")),React.createElement("div",{className:"inline-block"},React.createElement("span",{className:"glyphicon glyphicon-question-sign question",style:{top:"8px"},"data-toggle":"tooltip","data-placement":"bottom",title:"您的展台面积是否为特殊形状？例如：三角形、圆形、梯形等"})))),React.createElement("div",{className:"form-group"},React.createElement("label",{className:"col-md-2"},"报馆审批的时间："),React.createElement("div",{className:"col-md-10"},React.createElement("div",{className:"input-group date form_datetime"},React.createElement("input",{type:"text",name:"exhibition_verify_date",className:"form-control",readonly:!0,"data-bv-notempty":"true","data-bv-notempty-message":common.regex.empty_text}),React.createElement("span",{className:"input-group-addon"},React.createElement("i",{className:"glyphicon glyphicon-th"}))))),React.createElement("div",{className:"form-group"},React.createElement("label",{className:"col-md-2"},"进场搭建的时间："),React.createElement("div",{className:"col-md-10"},React.createElement("div",{className:"input-group date form_datetime"},React.createElement("input",{type:"text",name:"exhibition_enter_date",className:"form-control",readonly:!0,"data-bv-notempty":"true","data-bv-notempty-message":common.regex.empty_text}),React.createElement("span",{className:"input-group-addon"},React.createElement("i",{className:"glyphicon glyphicon-th"}))))),React.createElement("div",{className:"form-group"},React.createElement("label",{className:"col-md-2"},"展会开幕的时间："),React.createElement("div",{className:"col-md-10"},React.createElement("div",{className:"input-group date form_datetime"},React.createElement("input",{type:"text",name:"exhibition_begin_date",className:"form-control",readonly:!0,"data-bv-notempty":"true","data-bv-notempty-message":common.regex.empty_text}),React.createElement("span",{className:"input-group-addon"},React.createElement("i",{className:"glyphicon glyphicon-th"}))))),React.createElement("div",{className:"form-group"},React.createElement("label",{className:"col-md-2"},"撤展结束的时间："),React.createElement("div",{className:"col-md-10"},React.createElement("div",{className:"input-group date form_datetime"},React.createElement("input",{type:"text",name:"exhibition_leave_date",className:"form-control",readonly:!0,"data-bv-notempty":"true","data-bv-notempty-message":common.regex.empty_text}),React.createElement("span",{className:"input-group-addon"},React.createElement("i",{className:"glyphicon glyphicon-th"}))))),React.createElement("div",{className:"form-group"},React.createElement("label",{className:"col-md-2"},"备注说明："),React.createElement("div",{className:"col-md-10"},React.createElement("textarea",{className:"form-control",name:"remark",rows:"10","data-bv-stringlength":"true","data-bv-stringlength-max":"5","data-bv-stringlength-message":"不能输入超过255个字"}))),React.createElement("div",{className:"form-group"},React.createElement("label",{className:"col-md-2"},"上传重要资料："),React.createElement("div",{className:"col-md-10"},React.createElement(H5FIleUpload,{"data-inputText":"上传资料","data-fileUploadExDom":fileUploadExDom,"data-size":"2000000","data-errorFun":function(msg){me.setState({title:"错误",message:msg}),me.showAlert()}}))),React.createElement("div",{className:"row text-center"},React.createElement("button",{className:"btn btn-base btn-reset",onClick:me.reset},"重置"),React.createElement("button",{className:"btn btn-base btn-submit",onClick:me.submit},"生成表单")))),React.createElement(Bottom,null),React.createElement(Toolbar,null),React.createElement("div",{className:"modal fade",ref:"myModal",tabIndex:"-1",role:"dialog"},React.createElement(Alert,{title:this.state.title,message:this.state.message})))}});$(function(){ReactDOM.render(React.createElement(Writepayform,null),$(".htmlbody").get(0))})});