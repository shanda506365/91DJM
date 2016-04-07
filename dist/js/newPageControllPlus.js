"use strict";define(function(require,exports,module){var common=require("js/common");return function(param,$){var pageControllerPlus={containerId:param.containerId,totalCount:param.totalCount,pageSize:param.pageSize,totalPage:0,currPage:"undefined"!=typeof param.currPage?param.currPage:1,firstBtn:param.firstBtn,preBtn:param.preBtn,nextBtn:param.nextBtn,lastBtn:param.lastBtn,pageText:param.pageText,msgText:param.msgText,validateFun:param.validateFun,loadPageJson:param.loadPageJson,normalpost:param.normalpost?param.normalpost:!1,firstPage:function(){var me=this,oldPage=me.currPage,page1=1;return me.normalpost?void common.spellFilter("page",page1):void me.loadPageJson(page1,!1,!1,function(){me.currPage=1,me.pageChange()},function(){me.currPage=oldPage,me.pageChange()},me.validateFun)},prePage:function(){var me=this,oldPage=me.currPage,page1=me.currPage-1;return me.normalpost?void common.spellFilter("page",page1):void me.loadPageJson(page1,!1,!1,function(){me.currPage--,me.pageChange()},function(){me.currPage=oldPage,me.pageChange()},me.validateFun)},nextPage:function(){var me=this,oldPage=me.currPage,page1=me.currPage+1;return me.normalpost?void common.spellFilter("page",page1):void me.loadPageJson(page1,!1,!1,function(){me.currPage++,me.pageChange()},function(){me.currPage=oldPage,me.pageChange()},me.validateFun)},lastPage:function(){var me=this,oldPage=me.currPage,page1=me.totalPage;return me.normalpost?void common.spellFilter("page",page1):(me.pageChange(),void me.loadPageJson(page1,!1,!1,function(){me.currPage=me.totalPage,me.pageChange()},function(){me.currPage=oldPage,me.pageChange()},me.validateFun))},gotoPage:function(newPage){var me=this,oldPage=me.currPage,page1=parseInt(newPage);return me.normalpost?void common.spellFilter("page",page1):void me.loadPageJson(page1,!1,!1,function(){me.currPage=newPage,me.pageChange()},function(){me.currPage=oldPage,me.pageChange()},me.validateFun)},SetGotoPageEnterCssEvent:function(){var me=this;if(me.msgText){$("#"+me.containerId+" .gotoPageEnter").on({mouseover:function(){$(this).css("cursor");$(this).css({color:"#fff","background-color":"#6D7F89"})},mouseout:function(){$(this).css("cursor");$(this).css({color:"#000","background-color":"#fff","border-color":"#dddada"})},click:function(){var gotoPageDom=$("#"+me.containerId+" .gotoPageEnter").parent("label").children(".gotoPage");if(gotoPageDom.val()<=0)return void gotoPageDom.focus();if(gotoPageDom.val()!=me.currPage)return gotoPageDom.val()>me.totalPage?void gotoPageDom.focus():void me.gotoPage(gotoPageDom.val())}});var gotoPageTrpronum="";$("#"+me.containerId+" .gotoPage").on({focus:function(){$(this).css("cursor");$(this).css({"border-color":"#DD4400"})},blur:function(){$(this).css("cursor");$(this).css({"border-color":"#dddada"})},keyup:function(){var decimalReg=/^[1-9]\d{0,8}$/g;""!=this.value&&decimalReg.test(this.value)?gotoPageTrpronum=this.value:""!=this.value&&(this.value=gotoPageTrpronum)}})}$("#"+me.containerId+" .pageBtn").on({mouseover:function(){$(this).hasClass("curPageBtn")||$(this).css({color:"#fff","background-color":"#6D7F89"})},mouseout:function(){$(this).hasClass("curPageBtn")||$(this).css({color:"#000","background-color":"#fff","border-color":"#dddada"})},click:function(e){e.stopPropagation();var goPage=$(this).attr("pageSeed");goPage!=me.currPage&&me.gotoPage(goPage)}})},pageChange:function(){var me=this;me.currPage>1&&me.totalPage>=1?(me.firstBtn.style.cursor="pointer",me.firstBtn.style.color="black",me.firstBtn.onclick=function(){me.firstPage()},me.preBtn.style.cursor="pointer",me.preBtn.style.color="black",me.preBtn.onclick=function(){me.prePage()}):(me.firstBtn.style.cursor="default",me.firstBtn.style.color="gray",me.firstBtn.onclick=function(){},me.preBtn.style.cursor="default",me.preBtn.style.color="gray",me.preBtn.onclick=function(){}),me.currPage<me.totalPage?(me.lastBtn.style.cursor="pointer",me.lastBtn.style.color="black",me.lastBtn.onclick=function(){me.lastPage()},me.nextBtn.style.cursor="pointer",me.nextBtn.style.color="black",me.nextBtn.onclick=function(){me.nextPage()}):(me.lastBtn.style.cursor="default",me.lastBtn.style.color="gray",me.lastBtn.onclick=function(){},me.nextBtn.style.cursor="default",me.nextBtn.style.color="gray",me.nextBtn.onclick=function(){});var pageTextHtml="",startPage=1,endPage=5;startPage=me.currPage>2?me.currPage-2:1,endPage=me.currPage<me.totalPage-2?startPage+4>me.totalPage?me.totalPage:startPage+4:me.totalPage,4>endPage-startPage&&me.totalPage>=5&&(endPage=me.totalPage,startPage=me.totalPage-4>1?me.totalPage-4:1),startPage>1&&(pageTextHtml+='<span class="pageControllS">...</span>');for(var i=startPage;endPage>=i;i++)pageTextHtml+=i!=me.currPage?'<a class="pageBtn" style="color: #000;" pageSeed="'+i+'"  href="javascript:void(0)">'+i+"</a>":'<a class="pageBtn curPageBtn" style="color: #000;" pageSeed="'+i+'"  href="javascript:void(0)">'+i+"</a>";endPage<me.totalPage&&(pageTextHtml+='<span class="pageControllS">...</span>'),me.pageText.innerHTML=pageTextHtml;var gotoPageVal=parseInt(me.currPage)+1>me.totalPage?me.totalPage:parseInt(me.currPage)+1;me.msgText&&(me.msgText.innerHTML="共 "+me.totalPage+' 页，到第<input class="gotoPage" type="text" value="'+gotoPageVal+'"/>页 <input class="gotoPageEnter" type="button" value="GO"/>'),me.SetGotoPageEnterCssEvent()},InitPageController:function(isSearch){var me=this;me.totalPage=0,isSearch&&(me.currPage=1),me.totalCount%me.pageSize==0?me.totalPage=me.totalCount/me.pageSize:me.totalPage=parseInt(me.totalCount/me.pageSize)+1,me.currPage>me.totalPage&&(me.currPage=1),me.pageChange()}};return pageControllerPlus.totalCount%pageControllerPlus.pageSize==0?pageControllerPlus.totalPage=pageControllerPlus.totalCount/pageControllerPlus.pageSize:pageControllerPlus.totalPage=parseInt(pageControllerPlus.totalCount/pageControllerPlus.pageSize)+1,pageControllerPlus.pageChange(),pageControllerPlus}});