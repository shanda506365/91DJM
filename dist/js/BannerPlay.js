"use strict";define(function(require,exports,module){var $=require("jquery");require("js/bannerswipe")(window);var BannerPlay=React.createClass({displayName:"BannerPlay",componentDidMount:function(){var me=this,timeinterval=me.props["data-interal"]?me.props["data-interal"]:"5000",options={direction:"horizontal",loop:!0,autoplay:timeinterval,autoplayDisableOnInteraction:!0,paginationClickable:!0};this.props["data-pagination"]&&(options.pagination=".swiper-pagination"),this.props["data-npButton"]&&(options.nextButton=".swiper-button-next",options.prevButton=".swiper-button-prev"),this.props["data-scrollbar"]&&(options.scrollbar=".swiper-scrollbar");new Swiper("."+me.props["data-id"],options)},getInitialState:function(){var me=this,imgArr=me.props["data-imgs"],width=this.props["data-width"]?this.props["data-width"]:"100%";return{banerImgs:imgArr,banerImg:imgArr[0],width:width}},render:function(){var me=this,imgDoms=[];$.each(this.state.banerImgs,function(index,element){var random=(new Date).getTime();imgDoms.push(React.createElement("div",{className:"swiper-slide",key:"sl_"+index+random},React.createElement("a",{href:element.link}," ",React.createElement("img",{src:element.src}),"  ")))});var controllDoms=[];return this.props["data-pagination"]&&controllDoms.push(React.createElement("div",{key:"sl_pag",className:"swiper-pagination"})),this.props["data-npButton"]&&(controllDoms.push(React.createElement("div",{key:"sl_pre",className:"swiper-button-prev swiper-button-white hidden-xs"})),controllDoms.push(React.createElement("div",{key:"sl_nex",className:"swiper-button-next swiper-button-white hidden-xs"}))),this.props["data-scrollbar"]&&controllDoms.push(React.createElement("div",{key:"sl_scroll",className:"swiper-scrollbar"})),React.createElement("div",{className:me.props["data-id"]+"cont container bannerplay",style:{maxWidth:this.state.width}},React.createElement("div",{className:me.props["data-id"]+" swiper-container"},React.createElement("div",{className:"swiper-wrapper"},imgDoms),controllDoms))}});module.exports=BannerPlay});