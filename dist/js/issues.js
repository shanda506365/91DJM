"use strict";define(function(require,exports,module){var $=require("jquery"),Navagator=require("js/Navagator"),NavMenu=require("js/NavMenu"),Bottom=require("js/Bottom"),Toolbar=require("js/Toolbar"),Issues=React.createClass({displayName:"Issues",openOnlineQq:function(){window.open("http://b.qq.com/webc.htm?new=0&sid=6710582&o=91djm&q=7","_blank","height=502, width=644,toolbar=no,scrollbars=no,menubar=no,status=no")},render:function(){var me=this,dataTitle=$(".htmlbody").attr("data-title");$(".htmlbody").attr("data-content");return React.createElement("div",null,React.createElement(Navagator,null),React.createElement(NavMenu,{"data-index":"0"}),React.createElement("div",{className:"container issues"},React.createElement("img",{className:"img-responsive",src:dataTitle,alt:""}),React.createElement("div",{className:"body"},React.createElement("div",{className:"title"},React.createElement("span",{className:"glyphicon glyphicon-heart"}),"服务项目问题"),React.createElement("div",{className:"content"},"1、搭积木展览工程服务范围是什么？",React.createElement("br",null),"会展全行业特装展台设计、施工。",React.createElement("br",null),"2、搭积木除699元特装标准套餐外，是否还有其它服务项目？",React.createElement("br",null),"搭积木提供699元特装标准套餐外，还提供一对一展台个性定制设计施工服务。",React.createElement("br",null),"3、699元特装标准套餐是否适用于所有类型特装展台设计、施工？",React.createElement("br",null),"目前，699元特装标准套餐仅适用于展位面积100平方内的展台，超出该面积需要选择”个性定制“项目。",React.createElement("br",null),"4、699元特装标准套餐具体包含什么内容？",React.createElement("br",null),"根据您选择的平台固定规格展台设计图，页面有详细设计尺寸、施工物料的介绍。",React.createElement("br",null)),React.createElement("div",{className:"title"},React.createElement("span",{className:"glyphicon glyphicon-heart"}),"购买问题"),React.createElement("div",{className:"content"},"1、选择搭积木进行特装展台设计施工，如何预订及缴费？",React.createElement("br",null),"目前只接受搭积木官网预定：登陆搭积木官网www.djm-china.com，注册账号并进入相关页面，根据提示在线支付相应款项，可选择设计、施工服务。",React.createElement("br",null),"2、服务款项如何支付？",React.createElement("br",null),"搭积木官网支持前期预付款的线上支付及后期合同款项线上支付。（备注：签订合同的同时，需缴纳100%合同预付款。）",React.createElement("br",null),"3、交预付款后不想要服务了，预付款是否可以退还？",React.createElement("br",null),"交付预付款后，特装标准套餐未进行设计图修改前，预付款全额退还，如果已进行方案调整（改图及施工方案），则不予退回。特装个性定制未进行第三次改图前，预付款全额退还，如果已进行第三次设计方案调整，收取一半设计预付款，若已进行第四次设计 方案调整，则不予退回。",React.createElement("br",null),"4、在搭积木官网交付预付款后，多长时间有人联系？",React.createElement("br",null),"搭积木在收到客户提交的《服务需求表》24小时内，会有专门的人员与您电话沟通,确认您的要求。",React.createElement("br",null)),React.createElement("div",null,React.createElement("img",{style:{cursor:"pointer"},className:"center-block img-responsive",onClick:me.openOnlineQq,src:"images/icons/onlineSupport.png",alt:"点击这里给我发消息"})))),React.createElement(Bottom,null),React.createElement(Toolbar,null))}});$(function(){ReactDOM.render(React.createElement(Issues,null),$(".htmlbody").get(0))})});