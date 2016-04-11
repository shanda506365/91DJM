"use strict";define(function(require,exports,module){var $=require("jquery");require("lib/bootstrap.min")($),require("js/bootstrapValidator.sea")($),require("js/LoadMask")($);var common=require("js/common"),Navagator=require("js/Navagator"),NavMenu=require("js/NavMenu"),Bottom=require("js/Bottom"),Toolbar=require("js/Toolbar"),Alert=require("js/Alert");require("lib/chinamapPath")(window);var Submit=React.createClass({displayName:"Submit",showAlert:function(){$(this.refs.myModal).modal()},provinceChange:function(e){var me=this,target=e.target;$.ajax({type:"POST",url:common.createUrl($(".htmlbody").attr("data-ajax-getCity")),data:{area_code:$(target).val()},beforeSend:function(){$(".submit").loadingOverlay()},success:function(data){$(".submit").loadingOverlay("remove"),data.success?me.state.city=data.data:(me.setState({title:"错误",message:data.msg}),me.showAlert())},error:function(XMLHttpRequest,textStatus){$(".submit").loadingOverlay("remove"),me.setState({title:textStatus,message:JSON.stringify(XMLHttpRequest)}),me.showAlert()},dataType:"json"})},checkchange:function(){$(this.refs.checkpro).prop("checked")?$(".btn-submit").prop("disabled",!1):$(".btn-submit").prop("disabled","disabled")},componentDidMount:function(){var me=this;$(".submitForm").bootstrapValidator({message:common.regex.fail_text,feedbackIcons:{valid:common.feedbackIcons.valid,invalid:common.feedbackIcons.invalid,validating:common.feedbackIcons.validating}});var form=$(".submitForm").data("bootstrapValidator");$(".btn-submit").click(function(){if(form.isValid()){var arr=form.$form.serializeArray(),pid=[];$.each(me.state.items,function(index,item){pid.push(item.product_id)}),arr.push({name:"product_id",value:pid.join(",")}),$.ajax({type:"POST",url:common.createUrl($(".htmlbody").attr("data-ajax-submit")),data:arr,beforeSend:function(){$(".submit").loadingOverlay()},success:function(data){$(".submit").loadingOverlay("remove"),data.success?window.location.href="/":(me.setState({title:"错误",message:data.msg}),me.showAlert())},error:function(XMLHttpRequest,textStatus){$(".submit").loadingOverlay("remove"),me.setState({title:textStatus,message:JSON.stringify(XMLHttpRequest)}),me.showAlert()},dataType:"json"})}else document.documentElement.scrollTop=document.body.scrollTop=0})},getInitialState:function(){var dataCity=JSON.parse($(".htmlbody").attr("data-city")),dataOrderItem=JSON.parse($(".htmlbody").attr("data-order-item"));return{title:"消息",message:"...",city:dataCity.data,items:dataOrderItem}},render:function(){var me=this,dataBreadcrumb=JSON.parse($(".htmlbody").attr("data-breadcrumb")),breadcrumbDom=[];$.each(dataBreadcrumb,function(index,item){var cls="";return index==dataBreadcrumb.length-1?(breadcrumbDom.push(React.createElement("li",{className:"leaf"},item.name)),!1):void breadcrumbDom.push(React.createElement("li",null,React.createElement("a",{href:item.link,className:cls},item.name)))});var provinceDom=[];window.paintMap({path:function(){return{attr:function(){return null}}}});for(var pro in window.china)"510000"==china[pro].code?provinceDom.push(React.createElement("option",{value:china[pro].code,selected:"selected"},china[pro].alice)):provinceDom.push(React.createElement("option",{value:china[pro].code},china[pro].alice));var cityDom=[];$.each(me.state.city,function(index,city){0==index?cityDom.push(React.createElement("option",{value:city.area_code,selected:"selected"},city.area_name)):cityDom.push(React.createElement("option",{value:city.area_code},city.area_name))});var totlaPrcie=0,dataOrderItem=me.state.items,dataOrderItemDom=[];return $.each(dataOrderItem,function(index,item){totlaPrcie+=parseFloat(item.price),dataOrderItemDom.push(React.createElement("div",{className:"row itemCon"},React.createElement("div",{className:"col-md-6 col-sm-12  col-xs-12 item"},React.createElement("img",{src:item.image,alt:"暂无图片"}),item.product_name),React.createElement("div",{className:"col-md-3 col-sm-6 col-xs-6  item"},item.price),React.createElement("div",{className:"col-md-3 col-sm-6 col-xs-6  item"},React.createElement("a",{href:"###"},"移入收藏夹"))))}),React.createElement("div",null,React.createElement(Navagator,null),React.createElement(NavMenu,{"data-index":"4"}),React.createElement("div",{className:"container submit"},React.createElement("img",{src:"images/A41.jpg",alt:"",className:"banner"}),React.createElement("ol",{className:"breadcrumb"},breadcrumbDom),React.createElement("form",{className:"submitForm form-horizontal"},React.createElement("div",{className:"title"},"基本信息"),React.createElement("div",{className:"content"},React.createElement("div",{className:"form-group"},React.createElement("label",{className:"col-md-2"},"展台搭建的地点："),React.createElement("div",{className:"col-md-10"},React.createElement("div",{className:"col-md-6 provinceDiv"},React.createElement("select",{name:"province",onChange:me.provinceChange,className:"form-control col-md-6 province"},provinceDom)),React.createElement("div",{className:"col-md-6 cityDiv"},React.createElement("select",{name:"exhibition_area_code",className:"form-control col-md-6 city"},cityDom)))),React.createElement("div",{className:"form-group"},React.createElement("label",{className:"col-md-2"},"联系人姓名："),React.createElement("div",{className:"col-md-10"},React.createElement("input",{name:"contact_name",type:"text",className:"form-control"}))),React.createElement("div",{className:"form-group"},React.createElement("label",{className:"col-md-2"},"联系人电话："),React.createElement("div",{className:"col-md-10"},React.createElement("input",{name:"contact_mobile",type:"text",className:"form-control","data-bv-notempty":"true","data-bv-notempty-message":common.regex.empty_text,"data-bv-regexp":"true","data-bv-regexp-regexp":common.regex.telephone_partten,"data-bv-regexp-message":common.regex.telephone_text}))),React.createElement("div",{className:"form-group"},React.createElement("label",{className:"col-md-2"},"QQ："),React.createElement("div",{className:"col-md-10"},React.createElement("input",{name:"contact_qq",type:"text",className:"form-control"})))),React.createElement("div",{className:"title"},"标准化展台搭建说明"),React.createElement("div",{className:"content"},React.createElement("ol",null,React.createElement("li",null,'本项目仅限于展位面积100平方以下的展台搭建，若您的展位面积超出该范围请移步到"个性定制"页面。'),React.createElement("li",null,"本项目仅适用于平台固定风格的展位面积的展台搭建。"),React.createElement("li",null,"本项目提供一次设计图免费修改服务，且仅限于颜色、开口方向、画面方位的修改，不设计整体造型、材质、物料增加的修改。前期您将支付1000元作为预付款，设计图确认后进场施工前，支付展台搭建合同金额剩余款项到平台服务账户。"),React.createElement("li",null,"本项目暂不提供单纯设计图购买服务。")),React.createElement("div",{className:"checkbox"},React.createElement("label",null,React.createElement("input",{ref:"checkpro",className:"input-cb",type:"checkbox",onClick:this.checkchange}),"我已阅读同意接受以上相关说明条款"))),React.createElement("div",{className:"title"},"确认订单详情"),React.createElement("div",{className:"row"},React.createElement("div",{className:"col-md-6 head"},"订单内容"),React.createElement("div",{className:"col-md-3 head"},"单价"),React.createElement("div",{className:"col-md-3 head"},"操作")),React.createElement("div",{className:"content"},dataOrderItemDom),React.createElement("div",{className:"row"},React.createElement("div",{className:"col-md-12 footer"},React.createElement("label",null,"合计："),React.createElement("label",{className:"price"},"￥ ",totlaPrcie.toFixed(2),"  元"),React.createElement("button",{className:"btn btn-base btn-submit",disabled:"disabled"},"提交下单"),React.createElement("br",null),React.createElement("span",{className:"noti"},"下单完成后，请第一时间完善搭建资料"))))),React.createElement(Bottom,null),React.createElement(Toolbar,null),React.createElement("div",{className:"modal fade",ref:"myModal",tabIndex:"-1",role:"dialog"},React.createElement(Alert,{title:this.state.title,message:this.state.message})))}});$(function(){ReactDOM.render(React.createElement(Submit,null),$(".htmlbody").get(0))})});