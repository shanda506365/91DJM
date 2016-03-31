"use strict";define(function(require,exports,module){var $=require("jquery");require("js/bootstrapValidator.sea")($);var common=require("js/common"),Navagator=require("js/Navagator"),NavMenu=require("js/NavMenu"),Bottom=require("js/Bottom"),Toolbar=require("js/Toolbar"),Alert=require("js/Alert"),Register=React.createClass({displayName:"Register",showAlert:function(){$(this.refs.myModal).modal()},tabClick:function(){$(".tabdiv a").toggleClass("active"),$(".tabdiv .icon").toggleClass("glyphicon glyphicon-ok")},checkchange:function(){$(this.refs.checkpro).prop("checked")?$(".submit").prop("disabled",!1):$(".submit").prop("disabled","disabled")},getRandom:function(){var me=this;$.ajax({url:common.createUrl("../testData.json"),data:{},success:function(data){console.log(data)},error:function(XMLHttpRequest,textStatus){me.setState({title:textStatus,message:JSON.stringify(XMLHttpRequest)}),me.showAlert()},dataType:"json"})},componentDidMount:function(){$(".registerForm").bootstrapValidator({message:"验证失败",feedbackIcons:{valid:"glyphicon glyphicon-ok",invalid:"glyphicon glyphicon-remove",validating:"glyphicon glyphicon-refresh"},fields:{telephone:{message:"验证失败",validators:{notEmpty:{message:"不能为空"},regexp:{regexp:/^(\d{11})|(\+\d{13})$/,message:"请输入正确的手机号码"}}},random:{validators:{notEmpty:{message:"不能为空"},stringLength:{min:6,max:6,message:"请输入正确验证码"}}},password:{validators:{notEmpty:{message:"不能为空"},stringLength:{min:6,max:15,message:"请输入6到15位密码"}}},repassword:{validators:{notEmpty:{message:"不能为空"},stringLength:{min:6,max:15,message:"请输入6到15位密码"}}}}});var form=$(".registerForm").data("bootstrapValidator");$(".submit").click(function(){console.log($(".tabdiv>.active").attr("data-index")),form.isValid()&&$.getJSON(common.createUrl("../testData.json"),function(data){console.log(data)}).done(function(){}).fail(function(){alert("error")}).always(function(){})})},getInitialState:function(){return{title:"消息",message:"..."}},render:function(){return React.createElement("div",null,React.createElement(Navagator,null),React.createElement(NavMenu,{"data-index":"0"}),React.createElement("div",{className:"container register"},React.createElement("div",{className:"col-md-7 col-md-push-5"},React.createElement("img",{src:"images/B01.jpg",alt:"",className:"img-responsive"})),React.createElement("form",{className:"registerForm form-horizontal  col-md-5 col-md-pull-7"},React.createElement("div",{className:"form-group"},React.createElement("label",{className:"title"},"欢迎来到91搭积木  请注册")),React.createElement("div",{className:"form-group tabdiv"},React.createElement("a",{href:"###",onClick:this.tabClick,"data-index":"1",className:"active  text-center"},React.createElement("div",null,"设计师注册"),React.createElement("div",{className:"icon glyphicon glyphicon-ok"})),React.createElement("a",{href:"###",onClick:this.tabClick,"data-index":"2",className:"text-center"},React.createElement("div",null,"企业注册"),React.createElement("div",{className:"icon"}))),React.createElement("div",{className:"form-group"},React.createElement("input",{type:"text",className:"form-control",name:"telephone",placeholder:"手机号"})),React.createElement("div",{className:"form-group"},React.createElement("div",{className:"col-md-8 pl0"},React.createElement("input",{type:"text",className:"form-control",name:"random",placeholder:"动态码"})),React.createElement("a",{href:"###",onClick:this.getRandom,className:"getRandom"},"获取动态码")),React.createElement("div",{className:"form-group"},React.createElement("input",{type:"password",className:"form-control",name:"password",placeholder:"请输入密码，密码在6到15位之间"})),React.createElement("div",{className:"form-group"},React.createElement("input",{type:"password",className:"form-control",name:"repassword",placeholder:"确认密码"})),React.createElement("div",{className:"form-group checkbox"},React.createElement("label",null,React.createElement("input",{ref:"checkpro",type:"checkbox",onClick:this.checkchange})," ",React.createElement("span",{className:"grayf"},"我已经看过并同意 "),React.createElement("a",{href:"###",target:"_blank"},"《 用户协议 》"))),React.createElement("div",{className:"form-group"},React.createElement("button",{className:"btn btn-default submit",disabled:"disabled"},"同意协议并注册"),React.createElement("span",{className:"grayf"},"已有搭积木帐号?",React.createElement("a",{href:"login.html"},"立即登录"))))),React.createElement(Bottom,null),React.createElement(Toolbar,null),React.createElement("div",{className:"modal fade",ref:"myModal",tabIndex:"-1",role:"dialog"},React.createElement(Alert,{title:this.state.title,message:this.state.message})))}});$(function(){ReactDOM.render(React.createElement(Register,null),$(".htmlbody").get(0))})});