"use strict";var version=new Date,versionStr=version.getFullYear()+""+(version.getMonth()+1)+version.getDate();seajs.config({base:"/",paths:{images:"image",css:"css",js:"js",lib:"js/lib"},alias:{jquery:"lib/jquery.min",react:"lib/react.min","react-dom":"lib/react-dom.min"},map:[[/^(.*\.(?:css|js))(.*)$/i,"$1?v="+versionStr]],charset:"utf-8"});