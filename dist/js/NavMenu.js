"use strict";define(function(require,exports,module){var NavMenu=React.createClass({displayName:"NavMenu",render:function(){return React.createElement("div",{className:"navmenu",style:{filter:" progid:DXImageTransform.Microsoft.gradient( startColorstr='#dc214c', endColorstr='#71706e',GradientType=1 )"}},React.createElement("div",{className:"container"},React.createElement("ul",{className:"nav nav-pills"},React.createElement("li",{className:"logo"},React.createElement("img",{src:"images/A04.png",style:{display:"block"},alt:""})),React.createElement("li",{role:"presentation",className:"active"},React.createElement("a",{href:"#"},"首页")),React.createElement("li",{role:"presentation"},React.createElement("a",{href:"#"},"平台介绍")),React.createElement("li",{role:"presentation"},React.createElement("a",{href:"#"},"案例展示")),React.createElement("li",{role:"presentation"},React.createElement("a",{href:"#"},"效果图展示")),React.createElement("li",{role:"presentation"},React.createElement("a",{href:"#"},"标准化套餐")),React.createElement("li",{role:"presentation"},React.createElement("a",{href:"#"},"定制套餐")),React.createElement("li",{role:"presentation"},React.createElement("a",{href:"#"},"积木工厂")))))}});module.exports=NavMenu});