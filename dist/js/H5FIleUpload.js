"use strict";define(function(require,exports,module){var $=require("jquery");require("js/jquery.ui.widget")($),require("js/jquery.iframe-transport")($),require("js/jquery.fileupload")($),require("js/jquery.fileupload-process")($),require("js/jquery.fileupload-validate")($);var H5FIleUpload=React.createClass({displayName:"H5FIleUpload",componentDidMount:function(){var url="/upload/server/php/";$("#fileupload").fileupload({url:url,dataType:"json",acceptFileTypes:/(\.|\/)(gif|jpe?g|png)$/i,maxFileSize:999e3}).on("fileuploadprogressall",function(e,data){$("#fileupload").attr("disabled",!0);var progress=parseInt(data.loaded/data.total*100,10);$("#progress .progress-bar").css("width",progress+"%")}).on("fileuploaddone",function(e,data){console.log(e),console.log(data),$("#fileupload").attr("disabled",!1),$.each(data.result.files,function(index,file){$("<p/>").text(file.name).appendTo("#files")})}).on("fileuploadprocessalways",function(e,data){var index=data.index,file=data.files[index];file.error&&console.log(file)}).prop("disabled",!$.support.fileInput).parent().addClass($.support.fileInput?void 0:"disabled")},render:function(){return React.createElement("div",{className:"h5fileupload"},React.createElement("span",{className:"btn btn-success fileinput-button"},React.createElement("i",{className:"glyphicon glyphicon-plus"}),React.createElement("span",null,"上传"),React.createElement("input",{id:"fileupload",type:"file",name:"files[]",multiple:!0})),React.createElement("br",null),React.createElement("br",null),React.createElement("div",{id:"progress",className:"progress"},React.createElement("div",{className:"progress-bar progress-bar-success"})),React.createElement("div",{id:"files",className:"files"}),React.createElement("br",null))}});module.exports=H5FIleUpload});