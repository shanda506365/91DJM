"use strict";define(function(require,exports,module){var Dialog=(require("jquery"),React.createClass({displayName:"Dialog",render:function(){return React.createElement("div",{className:"modal-dialog",role:"document"},React.createElement("div",{className:"modal-content"},React.createElement("div",{className:"modal-header"},React.createElement("button",{type:"button",className:"close","data-dismiss":"modal","aria-label":"Close"},React.createElement("span",{"aria-hidden":"true"},"×")),React.createElement("h4",{className:"modal-title",id:"myModalLabel"},"Modal title")),React.createElement("div",{className:"modal-body"},"..."),React.createElement("div",{className:"modal-footer"},React.createElement("button",{type:"button",className:"btn btn-default","data-dismiss":"modal"},"Close"),React.createElement("button",{type:"button",className:"btn btn-primary"},"Save changes"))))}}));module.exports=Dialog});