"use strict";define(function(require,exports,module){var $=require("jquery");require("js/LoadMask")($);var common=require("js/common"),Alert=require("js/Alert"),ThumbView=React.createClass({displayName:"ThumbView",showAlert:function(){$(this.refs.myModal).modal()},colCount:3,rowCount:4,componentDidMount:function(){var me=this;if(this.props["data-ajax"]){var total=this.state.imgList.total;if(total>me.colCount*me.rowCount){var pagec=require("js/newPageControllPlus")({containerId:"example_pagging",totalCount:total,pageSize:me.colCount*me.rowCount,currPage:me.state.currpage,firstBtn:$("#example_pagging .firstBtn")[0],preBtn:$("#example_pagging .preBtn")[0],nextBtn:$("#example_pagging .nextBtn")[0],lastBtn:$("#example_pagging .lastBtn")[0],pageText:$("#example_pagging .pageText")[0],msgText:$("#example_pagging .msgText")[0],validateFun:!1,normalpost:!1,loadPageJson:function(page1,newurl,isSearch,okFun,errFun,validateFun){var pagging=this;$.ajax({url:common.createUrl("../testData.json"),data:{},success:function(data){console.log(data),pagging.totalCount=parseInt(data.total);var nowPage=page1;me.setState({currpage:nowPage}),pagging.currPage=nowPage,pagging.InitPageController(),me.setState({title:textStatus,message:JSON.stringify(XMLHttpRequest)})},error:function(XMLHttpRequest,textStatus){pagging.totalCount=100;var nowPage=page1;me.setState({currpage:nowPage}),pagging.currPage=nowPage,pagging.InitPageController(),me.setState({title:textStatus,message:JSON.stringify(XMLHttpRequest)}),me.showAlert()},dataType:"json"})}},$);pagec.InitPageController()}}},getInitialState:function(){var cp=$(".htmlbody").attr("data-currpage");return cp=cp?parseInt($(".htmlbody").attr("data-currpage")):1,{currpage:cp,title:"消息",message:"...",imgList:this.props["data-src"]}},render:function(){var me=this,imgDom=[],paggingDom=[];if(this.props["data-ajax"]){var model=this.props["data-model"],total=this.state.imgList.total,fillNum=me.colCount-this.state.imgList.data.length%me.colCount;if(console.log(fillNum),$.each(this.state.imgList.data,function(index,item){imgDom.push(React.createElement("div",{className:"col-md-4 col-sm-6 col-xs-6 thumbview-img-div"},React.createElement("img",{className:"img-responsive",src:item[model.src],alt:"图像丢失"}),React.createElement("div",{className:"des",title:item[model.des]},item[model.des]),React.createElement("div",{className:"text-right"},React.createElement("a",{href:item[model.link],"data-id":item[model.id],className:"btn btn-default btn-detail text-right",role:"button"},"查看详细 >"))))}),fillNum>0&&fillNum<me.colCount)for(var i=0;fillNum>i;i++)imgDom.push(React.createElement("div",{className:"col-md-4 col-sm-6 col-xs-6"}));total>me.colCount*me.rowCount&&paggingDom.push(React.createElement("div",{id:"example_pagging"},React.createElement("div",{className:"mypagecontroller"},React.createElement("a",{className:"firstBtn",style:{cursor:"default",color:"gray"},href:"###"},"首页"),React.createElement("a",{className:"preBtn",style:{cursor:"default",color:"gray"},href:"###"},"上一页"),React.createElement("label",{className:"pageText"}),React.createElement("a",{className:"nextBtn",style:{cursor:"default",color:"gray"},href:"###"},"下一页"),React.createElement("a",{className:"lastBtn",style:{cursor:"default",color:"gray"},href:"###"},"尾页"),React.createElement("label",{className:"msgText"}))))}else $.each(this.state.imgList,function(index,item){imgDom.push(React.createElement("div",{className:"col-md-4 col-sm-6 col-xs-6 thumbview-img-div"},React.createElement("img",{className:"img-responsive",src:item.src,alt:"图像丢失"}),React.createElement("div",{className:"des",title:item.des},item.des),React.createElement("div",{className:"text-right"},React.createElement("a",{href:item.link,className:"btn btn-default btn-detail text-right",role:"button"},"查看详细 >"))))});return React.createElement("div",{className:"container thumbview"},React.createElement("div",{className:"row"},imgDom),paggingDom,React.createElement("div",{className:"modal fade",ref:"myModal",tabIndex:"-1",role:"dialog"},React.createElement(Alert,{title:this.state.title,message:this.state.message})))}});module.exports=ThumbView});