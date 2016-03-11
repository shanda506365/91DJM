"use strict";define(function(require,exports,module){return function($){!function(factory){"function"==typeof define&&define.amd?define(["jquery"],factory):factory("object"==typeof exports?require("jquery"):window.jQuery)}(function($){var counter=0;$.ajaxTransport("iframe",function(options){if(options.async){var form,iframe,addParamChar,initialIframeSrc=options.initialIframeSrc||"javascript:false;";return{send:function(_,completeCallback){form=$('<form style="display:none;"></form>'),form.attr("accept-charset",options.formAcceptCharset),addParamChar=/\?/.test(options.url)?"&":"?","DELETE"===options.type?(options.url=options.url+addParamChar+"_method=DELETE",options.type="POST"):"PUT"===options.type?(options.url=options.url+addParamChar+"_method=PUT",options.type="POST"):"PATCH"===options.type&&(options.url=options.url+addParamChar+"_method=PATCH",options.type="POST"),counter+=1,iframe=$('<iframe src="'+initialIframeSrc+'" name="iframe-transport-'+counter+'"></iframe>').bind("load",function(){var fileInputClones,paramNames=$.isArray(options.paramName)?options.paramName:[options.paramName];iframe.unbind("load").bind("load",function(){var response;try{if(response=iframe.contents(),!response.length||!response[0].firstChild)throw new Error}catch(e){response=void 0}completeCallback(200,"success",{iframe:response}),$('<iframe src="'+initialIframeSrc+'"></iframe>').appendTo(form),window.setTimeout(function(){form.remove()},0)}),form.prop("target",iframe.prop("name")).prop("action",options.url).prop("method",options.type),options.formData&&$.each(options.formData,function(index,field){$('<input type="hidden"/>').prop("name",field.name).val(field.value).appendTo(form)}),options.fileInput&&options.fileInput.length&&"POST"===options.type&&(fileInputClones=options.fileInput.clone(),options.fileInput.after(function(index){return fileInputClones[index]}),options.paramName&&options.fileInput.each(function(index){$(this).prop("name",paramNames[index]||options.paramName)}),form.append(options.fileInput).prop("enctype","multipart/form-data").prop("encoding","multipart/form-data"),options.fileInput.removeAttr("form")),form.submit(),fileInputClones&&fileInputClones.length&&options.fileInput.each(function(index,input){var clone=$(fileInputClones[index]);$(input).prop("name",clone.prop("name")).attr("form",clone.attr("form")),clone.replaceWith(input)})}),form.append(iframe).appendTo(document.body)},abort:function(){iframe&&iframe.unbind("load").prop("src",initialIframeSrc),form&&form.remove()}}}}),$.ajaxSetup({converters:{"iframe text":function(iframe){return iframe&&$(iframe[0].body).text()},"iframe json":function(iframe){return iframe&&$.parseJSON($(iframe[0].body).text())},"iframe html":function(iframe){return iframe&&$(iframe[0].body).html()},"iframe xml":function(iframe){var xmlDoc=iframe&&iframe[0];return xmlDoc&&$.isXMLDoc(xmlDoc)?xmlDoc:$.parseXML(xmlDoc.XMLDocument&&xmlDoc.XMLDocument.xml||$(xmlDoc.body).html())},"iframe script":function(iframe){return iframe&&$.globalEval($(iframe[0].body).text())}}})})}});