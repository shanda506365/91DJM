"use strict";define(function(require,exports,module){var $=require("jquery");require("js/bootstrapValidator.sea")($),require("js/LoadMask")($);var common=require("js/common"),Navagator=require("js/Navagator"),NavMenu=require("js/NavMenu"),Bottom=require("js/Bottom"),Toolbar=require("js/Toolbar"),Alert=require("js/Alert"),Register=React.createClass({displayName:"Register",showAlert:function(){$(this.refs.myModal).modal()},tabClick:function(){$(".tabdiv a").toggleClass("active"),$(".tabdiv .icon").toggleClass("glyphicon glyphicon-ok")},checkchange:function(){$(this.refs.checkpro).prop("checked")?$(".submit").prop("disabled",!1):$(".submit").prop("disabled","disabled")},lockRandom:function(time){var target=$(".getRandom"),time=time;if(0==time&&$.cookie("getRandom")&&(time=$.cookie("getRandom")),0!=time){target.prop("disabled","disabled"),target.val("("+time+")后重发"),$.cookie("getRandom",time,{expires:30});var inId=setInterval(function(){time--,target.val("("+time+")后重发"),$.cookie("getRandom",time,{expires:30}),0==time&&(target.val("获取动态码"),target.prop("disabled",!1),$.removeCookie("getRandom"),clearInterval(inId))},1e3)}},getRandom:function(e){var me=this,form=$(".registerForm").data("bootstrapValidator");form.validateField("mobile")&&(me.lockRandom(60),$.ajax({url:common.createUrl($(".htmlbody").attr("data-getRandom-url")),data:{mobile:form.getFieldElements("mobile").val()},beforeSend:function(){$(".register").loadingOverlay()},success:function(data){$(".register").loadingOverlay("remove"),data.success?(me.setState({title:"提示",message:"动态码已通过发送到您的手机"}),me.showAlert()):(me.setState({title:"错误",message:data.msg}),me.showAlert())},error:function(XMLHttpRequest,textStatus){$(".register").loadingOverlay("remove"),me.setState({title:textStatus,message:JSON.stringify(XMLHttpRequest)}),me.showAlert()},dataType:"json"}))},componentDidMount:function(){var me=this;me.lockRandom(0),$(".registerForm").bootstrapValidator({message:common.regex.fail_text,feedbackIcons:{valid:common.feedbackIcons.valid,invalid:common.feedbackIcons.invalid,validating:common.feedbackIcons.validating},fields:{mobile:{message:common.regex.fail_text,validators:{notEmpty:{message:common.regex.empty_text},regexp:{regexp:common.regex.telephone,message:common.regex.telephone_text}}},random:{validators:{notEmpty:{message:common.regex.empty_text},regexp:{regexp:common.regex.random,message:common.regex.random_text}}},password:{validators:{notEmpty:{message:common.regex.empty_text},regexp:{regexp:common.regex.password,message:common.regex.password_text}}},confirm:{validators:{notEmpty:{message:"不能为空"},regexp:{regexp:common.regex.password,message:common.regex.password_text}}}}});var form=$(".registerForm").data("bootstrapValidator");$(".submit").click(function(){if(form.isValid()){var arr=form.$form.serializeArray();arr.push({name:"customer_group_id",value:$(".tabdiv>.active").attr("data-index")}),$.ajax({type:"POST",url:common.createUrl($(".htmlbody").attr("data-regeister-url")),data:arr,beforeSend:function(){$(".register").loadingOverlay()},success:function(data){$(".register").loadingOverlay("remove"),data.success?window.location.href="/account/login.html":(me.setState({title:"错误",message:data.msg}),me.showAlert())},error:function(XMLHttpRequest,textStatus){$(".register").loadingOverlay("remove"),me.setState({title:textStatus,message:JSON.stringify(XMLHttpRequest)}),me.showAlert()},dataType:"json"})}})},getInitialState:function(){return{title:"消息",message:"..."}},render:function(){var dataBanner=JSON.parse($(".htmlbody").attr("data-banner"))[0];return React.createElement("div",null,React.createElement(Navagator,null),React.createElement(NavMenu,{"data-index":"0"}),React.createElement("div",{className:"container register"},React.createElement("div",{className:"col-md-7 col-md-push-5"},React.createElement("img",{src:dataBanner.src,alt:dataBanner.des,className:"img-responsive"})),React.createElement("form",{className:"registerForm form-horizontal  col-md-5 col-md-pull-7"},React.createElement("div",{className:"form-group"},React.createElement("label",{className:"title"},"欢迎来到91搭积木  请注册")),React.createElement("div",{className:"form-group tabdiv"},React.createElement("a",{href:"###",onClick:this.tabClick,"data-index":"2",className:"active  text-center"},React.createElement("div",null,"设计师注册"),React.createElement("div",{className:"icon glyphicon glyphicon-ok"})),React.createElement("a",{href:"###",onClick:this.tabClick,"data-index":"1",className:"text-center"},React.createElement("div",null,"企业注册"),React.createElement("div",{className:"icon"}))),React.createElement("div",{className:"form-group"},React.createElement("input",{type:"text",className:"form-control",name:"mobile",placeholder:"手机号"})),React.createElement("div",{className:"form-group"},React.createElement("div",{className:"col-md-8 pl0"},React.createElement("input",{type:"text",className:"form-control",name:"random",placeholder:"动态码"})),React.createElement("input",{type:"button",onClick:this.getRandom,className:"btn btn-default getRandom",value:"获取动态码"})),React.createElement("div",{className:"form-group"},React.createElement("input",{type:"password",className:"form-control","data-bv-identical":"true","data-bv-identical-field":"confirm","data-bv-identical-message":common.regex.identical_text,name:"password",placeholder:common.regex.password_text})),React.createElement("div",{className:"form-group"},React.createElement("input",{type:"password",className:"form-control","data-bv-identical":"true","data-bv-identical-field":"password","data-bv-identical-message":common.regex.identical_text,name:"confirm",placeholder:common.regex.repassword_text})),React.createElement("div",{className:"form-group checkbox"},React.createElement("label",null,React.createElement("input",{ref:"checkpro",type:"checkbox",onClick:this.checkchange})," ",React.createElement("span",{className:"grayf"},"我已经看过并同意 "),React.createElement("a",{href:"###",target:"_blank"},"《 用户协议 》"))),React.createElement("div",{className:"form-group"},React.createElement("button",{className:"btn btn-default submit",disabled:"disabled"},"同意协议并注册"),React.createElement("span",{className:"grayf"},"已有搭积木帐号?",React.createElement("a",{href:"/account/login"},"立即登录"))))),React.createElement(Bottom,null),React.createElement(Toolbar,null),React.createElement("div",{className:"modal fade",ref:"myModal",tabIndex:"-1",role:"dialog"},React.createElement(Alert,{title:this.state.title,message:this.state.message})))}});$(function(){ReactDOM.render(React.createElement(Register,null),$(".htmlbody").get(0))})});