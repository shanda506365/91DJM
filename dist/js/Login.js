"use strict";define(function(require,exports,module){var $=require("jquery");require("js/bootstrapValidator.sea")($);var common=require("js/common"),Navagator=require("js/Navagator"),NavMenu=require("js/NavMenu"),Bottom=require("js/Bottom"),Toolbar=require("js/Toolbar"),Alert=require("js/Alert"),Login=React.createClass({displayName:"Login",showAlert:function(){$(this.refs.myModal).modal()},componentDidMount:function(){var me=this;$(".loginForm").bootstrapValidator({message:common.regex.fail_text,feedbackIcons:{valid:common.feedbackIcons.valid,invalid:common.feedbackIcons.invalid,validating:common.feedbackIcons.validating},fields:{telephone:{message:common.regex.fail_text,validators:{notEmpty:{message:common.regex.empty_text},regexp:{regexp:common.regex.telephone,message:common.regex.telephone_text}}},random:{validators:{notEmpty:{message:common.regex.empty_text},regexp:{regexp:common.regex.random,message:common.regex.random_text}}},password:{validators:{notEmpty:{message:common.regex.empty_text},regexp:{regexp:common.regex.password,message:common.regex.password_text}}}}});var form=$(".loginForm").data("bootstrapValidator");$(".submit").click(function(){me.setState({title:"加载中...",message:"加载中..."}),me.showAlert(),form.isValid()&&$.ajax({url:common.createUrl("../testData.json"),data:{},success:function(data){console.log(data),$(this.refs.checkpro).prop("checked")},error:function(XMLHttpRequest,textStatus){me.setState({title:textStatus,message:JSON.stringify(XMLHttpRequest)}),me.showAlert()},dataType:"json"})})},getInitialState:function(){return{title:"消息",message:"..."}},render:function(){return React.createElement("div",null,React.createElement(Navagator,null),React.createElement(NavMenu,{"data-index":"0"}),React.createElement("div",{className:"container login"},React.createElement("form",{className:"loginForm form-horizontal center-block"},React.createElement("div",{className:"form-group"},React.createElement("label",{className:"title"},"欢迎来到91搭积木  请登录")),React.createElement("div",{className:"form-group"},React.createElement("input",{type:"text",className:"form-control",name:"telephone",placeholder:"手机号"})),React.createElement("div",{className:"form-group"},React.createElement("input",{type:"password",className:"form-control",name:"password",placeholder:"密码"})),React.createElement("div",{className:"form-group checkbox"},React.createElement("label",null,React.createElement("input",{ref:"checkpro",type:"checkbox"}),React.createElement("span",{className:"grayf"},"下次自动登录 "))),React.createElement("div",{className:"form-group"},React.createElement("button",{className:"btn btn-default submit"},"登  录"),React.createElement("span",{className:"grayf"},"还没有注册?",React.createElement("a",{href:"register.html"},"免费注册")),React.createElement("span",{className:"grayf",style:{"float":"right",display:"inline-block"}},React.createElement("a",{href:"forgotpass.html"},"忘记密码"))))),React.createElement(Bottom,null),React.createElement(Toolbar,null),React.createElement("div",{className:"modal fade",ref:"myModal",tabIndex:"-1",role:"dialog"},React.createElement(Alert,{title:this.state.title,message:this.state.message})))}});$(function(){ReactDOM.render(React.createElement(Login,null),$(".htmlbody").get(0))})});