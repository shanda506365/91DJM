"use strict";define(function(require,exports,module){var $=require("jquery"),BannerPlay=(require("lib/jquery.easing.min"),require("js/BannerPlay")),ThumbView=require("js/ThumbView"),common=require("js/common"),SvgMap=require("js/SvgMap"),H5FIleUpload=require("js/H5FIleUpload"),Navagator=require("js/Navagator"),Progress=require("js/Progress"),Index=React.createClass({displayName:"Index",componentDidMount:function(){},render:function(){console.log(common.getNagavVersion());var imgArr=JSON.parse($("body").attr("data-img")),json=JSON.parse($("body").attr("data-json"));return console.log(JSON.stringify({name:"22d2",ddd:111})),console.log(json),console.log(json.data[0]),React.createElement("div",{className:"container"},React.createElement(Progress,null),React.createElement("div",{className:"mybuttonDiv"},React.createElement("div",{className:"line"}),React.createElement("div",{className:"mybutton"}),React.createElement("div",{className:"line"})),React.createElement(Navagator,null),React.createElement(SvgMap,null),React.createElement(H5FIleUpload,null),React.createElement(BannerPlay,{"data-imgs":imgArr}),React.createElement(ThumbView,null),React.createElement("div",{className:"row"},React.createElement("img",{style:{"max-width":"100%"},src:imgArr[0],alt:imgArr[0]})),React.createElement("div",{className:"row"},React.createElement("div",{className:"col-md-6 col-sm-6",style:{"padding-top":"60px","padding-bottom":"60px",backgroundColor:"red"}},React.createElement("h3",null,React.createElement("small",null,"当季新品"),"层层滋味 开春清新"),React.createElement("p",null,"      花开春日，两款水果风味甜品清新登场。层层覆盆子蛋糕，酸甜可口。酥香蜜桃挞，金黄蜜桃，酥脆浓香。来一口春天滋味。")),React.createElement("div",{className:"col-md-6 col-sm-6"},React.createElement("img",{className:"center-block",src:"images/31.jpg",alt:imgArr[0]}))),React.createElement("ul",{className:"nav nav-tabs"},React.createElement("li",{role:"presentation",className:"active"},React.createElement("a",{href:"#"},"首页")),React.createElement("li",{role:"presentation"},React.createElement("a",{href:"#"},"介绍")),React.createElement("li",{role:"presentation"},React.createElement("a",{href:"#"},"消息"))))}});$(function(){ReactDOM.render(React.createElement(Index,null),$("body").get(0))})});