"use strict";define(function(require,exports,module){var Alert=(require("jquery"),React.createClass({displayName:"Alert",render:function(){return React.createElement("div",{className:"modal-dialog",role:"document"},React.createElement("div",{className:"modal-content"},React.createElement("div",{className:"modal-header"},React.createElement("button",{type:"button",className:"close","data-dismiss":"modal","aria-label":"Close"},React.createElement("span",{"aria-hidden":"true"},"×")),React.createElement("h4",{className:"modal-title",id:"myModalLabel"},this.props.title)),React.createElement("div",{className:"modal-body",style:{maxHeight:"400px",overflow:"auto"}},this.props.message),React.createElement("div",{className:"modal-footer"},React.createElement("button",{type:"button",className:"btn btn-default","data-dismiss":"modal"},"确定"))))}}));module.exports=Alert});