"use strict";define(function(require,exports,module){var $=require("jquery");require("js/bannerswipe")(window);var BannerPlay=React.createClass({displayName:"BannerPlay",componentDidMount:function(){var me=this;me.props["data-interal"]?me.props["data-interal"]:"5000",new Swiper(".swiper-container",{direction:"horizontal",loop:!0,autoplay:5e3,autoplayDisableOnInteraction:!0,pagination:".swiper-pagination",nextButton:".swiper-button-next",prevButton:".swiper-button-prev",scrollbar:".swiper-scrollbar",paginationClickable:!0,paginationBulletRender:function(index,className){return'<span class="'+className+'">'+(index+1)+"</span>"}})},getInitialState:function(){var me=this,imgArr=me.props["data-imgs"],width=this.props["data-width"]?this.props["data-width"]:"100%";return{banerImgs:imgArr,banerImg:imgArr[0],width:width}},render:function(){var imgDoms=[];return $.each(this.state.banerImgs,function(index,element){imgDoms.push(React.createElement("div",{className:"swiper-slide",key:index},React.createElement("img",{src:element})))}),React.createElement("div",{className:"container",style:{maxWidth:this.state.width}},React.createElement("div",{className:"swiper-container"},React.createElement("div",{className:"swiper-wrapper"},imgDoms),React.createElement("div",{className:"swiper-pagination"}),React.createElement("div",{className:"swiper-button-prev"}),React.createElement("div",{className:"swiper-button-next"}),React.createElement("div",{className:"swiper-scrollbar"})))}});module.exports=BannerPlay});