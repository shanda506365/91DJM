"use strict";define(function(require,exports,module){var common={getNagavVersion:function(){var s,Sys={},ua=navigator.userAgent.toLowerCase();return(s=ua.match(/msie ([\d.]+)/))?Sys.isIE=s[1]:(s=ua.match(/firefox\/([\d.]+)/))?Sys.isGecko=s[1]:(s=ua.match(/chrome\/([\d.]+)/))?Sys.isWebkit=s[1]:(s=ua.match(/opera.([\d.]+)/))?Sys.IsOpera=s[1]:(s=ua.match(/version\/([\d.]+).*safari/))?Sys.isSafari=s[1]:(s=ua.match(/rv:([\d.]+)/))?Sys.isEdge=s[1]:0,Sys}};module.exports=common});