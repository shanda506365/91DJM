"use strict";define(function(require,exports,module){var Customer_h_nav=React.createClass({displayName:"Customer_h_nav",render:function(){return React.createElement("ul",{className:"nav nav-pills nav-stacked customer_h_nav"},React.createElement("li",{className:"title"},React.createElement("span",{className:"glyphicon glyphicon-user"}),"个人中心"),React.createElement("li",null,React.createElement("a",{href:"/customer_info.html"},"个人信息")),React.createElement("li",null,React.createElement("a",{href:"/customer_editPassword.html"},"修改密码")),React.createElement("li",null,React.createElement("a",{href:"/account/email"},"邮箱绑定")),React.createElement("li",null,React.createElement("a",{href:"/account/mobile"},"手机绑定")),React.createElement("div",{className:"clearfix"}),React.createElement("li",{className:"title"},React.createElement("span",{className:"glyphicon glyphicon-list-alt"}),"订单中心"),React.createElement("li",null,React.createElement("a",{href:"/account/order"},"我的订单")),React.createElement("li",null,React.createElement("a",{href:"/customer_favorite.html"},"我的收藏")),React.createElement("div",{className:"clearfix"}),React.createElement("li",{className:"title"},React.createElement("span",{className:"glyphicon glyphicon-tree-deciduous"}),"设计作品"),React.createElement("li",null,React.createElement("a",{href:"/customer_work.html"},"我的作品")),React.createElement("li",null,React.createElement("a",{href:"/customer_upload.html"},"上传作品")))}});module.exports=Customer_h_nav});