"use strict";define(function(require,exports,module){var $=require("jquery");require("js/LoadMask")($);var common=require("js/common"),Alert=require("js/Alert"),ThumbView=React.createClass({displayName:"ThumbView",colCount:3,rowCount:4,pagec:null,filterClick:function(e){var me=this,target=$(e.target);target.siblings(".active").removeClass("active"),target.addClass("active");var gid=target.parent(".filter").siblings(".title").attr("data-gid"),arr=me.state.filter,newArr=[];$.each(arr,function(index,item){item.gid!=gid&&newArr.push(item)});var fid=$(e.target).attr("data-fid");"all"!=fid&&newArr.push({gid:gid,fid:target.attr("data-fid"),fname:target.text()}),me.setState({filter:newArr},function(previousState,currentProps){me.ajaxPost(me.pagec,me.state.currpage,me.pagec.totalCount)})},removeFilter:function(e){var me=this,fid=$(e.target).parent("a").attr("data-fid");"undefined"==typeof fid&&(fid=$(e.target).attr("data-fid")),$("a[data-fid="+fid+"]").removeClass("active"),$("a[data-fid="+fid+"]").siblings('a[data-fid="all"]').addClass("active");var arr=me.state.filter,newArr=[];$.each(arr,function(index,item){item.fid!=fid&&newArr.push(item)}),me.setState({filter:newArr},function(previousState,currentProps){me.ajaxPost(me.pagec,me.state.currpage,me.pagec.totalCount)})},sortClick:function(e){var me=this,target=$(e.target),sort=target.attr("data-sid");target.addClass("active"),target.siblings("a").removeClass("active"),me.setState({sort:sort},function(previousState,currentProps){me.ajaxPost(me.pagec,me.state.currpage,me.pagec.totalCount)})},ajaxPost:function(pagging,page1,total){var me=this,fid=[];$.each(me.state.filter,function(index,item){fid.push(item.fid)}),$.ajax({type:"POST",url:common.createUrl(me.props["data-ajax-url"]),data:{page:page1,sort:me.state.sort,filter:fid.join(",")},beforeSend:function(){$(".thumbview").loadingOverlay()},success:function(data){if($(".thumbview").loadingOverlay("remove"),data.suc){pagging.totalCount=parseInt(data.total);var nowPage=page1;me.setState({currpage:nowPage,imgList:data},function(previousState,currentProps){pagging.currPage=nowPage,pagging.InitPageController()})}else me.setState({title:"消息",message:data.msg}),me.showAlert()},error:function(XMLHttpRequest,textStatus){$(".thumbview").loadingOverlay("remove"),me.setState({title:textStatus,message:JSON.stringify(XMLHttpRequest)}),me.showAlert()},dataType:"json"})},thumbsUp:function(e,pid){var me=this,collectNum=($(e.target),$(".num_"+pid)),hasNum=collectNum.siblings(".glyphicon");$.ajax({type:"POST",url:common.createUrl(me.props["data-ajax-thumbsUp"]),data:{product_id:pid},beforeSend:function(){$(".thumbview").loadingOverlay()},success:function(data){if($(".thumbview").loadingOverlay("remove"),data.suc){var num=parseInt(data.data);collectNum.text(num),0==num&&hasNum.removeClass("hasNum")}else me.setState({title:"消息",message:data.msg}),me.showAlert()},error:function(XMLHttpRequest,textStatus){$(".thumbview").loadingOverlay("remove"),me.setState({title:textStatus,message:JSON.stringify(XMLHttpRequest)}),me.showAlert()},dataType:"json"})},showAlert:function(){$(this.refs.myModal).modal()},componentDidMount:function(){var me=this;if(this.props["data-ajax"]){var total=this.state.imgList.total;me.pagec=require("js/newPageControllPlus")({containerId:"example_pagging",totalCount:total,pageSize:me.colCount*me.rowCount,currPage:me.state.currpage,firstBtn:$("#example_pagging .firstBtn")[0],preBtn:$("#example_pagging .preBtn")[0],nextBtn:$("#example_pagging .nextBtn")[0],lastBtn:$("#example_pagging .lastBtn")[0],pageText:$("#example_pagging .pageText")[0],msgText:$("#example_pagging .msgText")[0],validateFun:!1,normalpost:!1,loadPageJson:function(page1,newurl,isSearch,okFun,errFun,validateFun){var pagging=this;me.ajaxPost(pagging,page1,total)}},$),me.pagec.InitPageController()}},getInitialState:function(){var cp=$(".htmlbody").attr("data-currpage");return cp=cp?parseInt($(".htmlbody").attr("data-currpage")):1,{currpage:cp,title:"消息",message:"...",imgList:this.props["data-src"],filter:[],sort:"1"}},render:function(){var me=this,imgDom=[],paggingDom=[],categoryDom=[],sortDom=[];if(me.props["data-ajax"]){var model=me.props["data-model"],total=me.state.imgList.total,fillNum=me.colCount-me.state.imgList.data.length%me.colCount;if($.each(me.state.imgList.data,function(index,item){var designerDom=[];if(model.designer_id){var hasNum=item[model.collect_num]>0?"hasNum":"";designerDom.push(React.createElement("div",{className:"left-block"},React.createElement("a",{href:"###",onClick:function(e){me.thumbsUp(e,item[model.product_id])},className:"thumbs-up"},React.createElement("span",{className:"glyphicon glyphicon-thumbs-up "+hasNum}),React.createElement("span",{className:"collectNum num_"+item[model.designer_id]},item[model.collect_num]),React.createElement("span",{className:"designer"},item[model.designer_name]))))}imgDom.push(React.createElement("div",{className:"col-md-4 col-sm-6 col-xs-6 thumbview-img-div"},React.createElement("a",{href:item.link},React.createElement("img",{className:"img-responsive",src:item[model.src],alt:"图像丢失"})),React.createElement("div",{className:"des",title:item[model.des]},item[model.des]),React.createElement("div",{className:""},designerDom,React.createElement("div",{className:"right-block"},React.createElement("a",{href:item[model.link],"data-id":item[model.id],className:"btn btn-default btn-detail text-right",role:"button"},"查看详细 >")))))}),0==imgDom.length&&imgDom.push(React.createElement("div",{className:"text-center"},"暂无结果")),fillNum>0&&fillNum<me.colCount)for(var i=0;fillNum>i;i++)imgDom.push(React.createElement("div",{className:"col-md-4 col-sm-6 col-xs-6"}));var paddingCls="";total<=me.colCount*me.rowCount&&(paddingCls="hidden"),paggingDom.push(React.createElement("div",{id:"example_pagging",className:"text-center "+paddingCls},React.createElement("div",{className:"mypagecontroller"},React.createElement("a",{className:"firstBtn",style:{cursor:"default",color:"gray"},href:"###"},"首页"),React.createElement("a",{className:"preBtn",style:{cursor:"default",color:"gray"},href:"###"},"上一页"),React.createElement("label",{className:"pageText"}),React.createElement("a",{className:"nextBtn",style:{cursor:"default",color:"gray"},href:"###"},"下一页"),React.createElement("a",{className:"lastBtn",style:{cursor:"default",color:"gray"},href:"###"},"尾页"),React.createElement("label",{className:"msgText"})))),me.props["data-sort"]&&sortDom.push(React.createElement("div",{className:"sorter"},React.createElement("a",{className:"active",onClick:me.sortClick,"data-sid":"1",href:"###"},"最新"),React.createElement("a",{"data-sid":"2",onClick:me.sortClick,href:"###"},"人气"),React.createElement("div",{className:"right-block"},"共找到",React.createElement("label",null,total),"个案例")))}else $.each(me.state.imgList,function(index,item){imgDom.push(React.createElement("div",{className:"col-md-4 col-sm-6 col-xs-6 thumbview-img-div"},React.createElement("a",{href:item.link},React.createElement("img",{className:"img-responsive",src:item.src,alt:"图像丢失"})),React.createElement("div",{className:"des",title:item.des},item.des),React.createElement("div",{className:"text-right"},React.createElement("a",{href:item.link,className:"btn btn-default btn-detail text-right",role:"button"},"查看详细 >"))))});return me.props["data-category"]&&!function(){var categoryArr=me.props["data-category"],categoryItemDom=[];$.each(categoryArr,function(index,category){var child=[];child.push(React.createElement("a",{className:"active",onClick:me.filterClick,href:"###","data-fid":"all"},"全部")),$.each(category.filter,function(index,filter){child.push(React.createElement("a",{onClick:me.filterClick,href:"###","data-fid":filter.filter_id},filter.name))}),categoryItemDom.push(React.createElement("div",{className:"row myrow"},React.createElement("div",{className:"title col-md-2 text-right","data-gid":category.filter_group_id},category.name,"："),React.createElement("div",{className:"filter col-md-10"},child)))});var filterItemDom=[];$.each(me.state.filter,function(index,item){filterItemDom.push(React.createElement("a",{onClick:me.removeFilter,"data-fid":item.fid,href:"###"},item.fname,React.createElement("span",{className:"glyphicon glyphicon-remove-sign"})))});var filterDom=[];me.state.filter.length>0&&filterDom.push(React.createElement("div",{className:"filterCondition row"},React.createElement("div",{className:"title col-md-2 text-right"},"筛选条件："),React.createElement("div",{className:"condition col-md-10"},filterItemDom))),categoryDom.push(React.createElement("div",{className:"category"},categoryItemDom,filterDom))}(),React.createElement("div",{className:"container thumbview"},categoryDom,sortDom,React.createElement("div",{className:"row"},imgDom),paggingDom,React.createElement("div",{className:"modal fade",ref:"myModal",tabIndex:"-1",role:"dialog"},React.createElement(Alert,{title:this.state.title,message:this.state.message})))}});module.exports=ThumbView});