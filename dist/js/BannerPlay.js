"use strict";define(function(require,exports,module){require("jquery");require("js/bannerswipe")(window);var BannerPlay=React.createClass({displayName:"BannerPlay",componentDidMount:function(){var me=this;me.props["data-interal"]?me.props["data-interal"]:"5000",new Swiper(".swiper-container",{direction:"horizontal",loop:!0,autoplay:2e3,autoplayDisableOnInteraction:!0,pagination:".swiper-pagination",nextButton:".swiper-button-next",prevButton:".swiper-button-prev",scrollbar:".swiper-scrollbar",paginationClickable:!0,paginationBulletRender:function(index,className){return'<span class="'+className+'">'+(index+1)+"</span>"}})},getInitialState:function(){var me=this,imgArr=me.props["data-imgs"];return{banerImgs:imgArr,banerImg:imgArr[0]}},render:function(){return React.createElement("div",{className:"swiper-container"},React.createElement("div",{className:"swiper-wrapper"},React.createElement("div",{className:"swiper-slide"},React.createElement("img",{src:"images/11.jpg"})),React.createElement("div",{className:"swiper-slide"},React.createElement("img",{src:"images/12.jpg"})),React.createElement("div",{className:"swiper-slide"},React.createElement("img",{src:"images/13.jpg"})),React.createElement("div",{className:"swiper-slide"},React.createElement("img",{src:"images/14.jpg"})),React.createElement("div",{className:"swiper-slide"},React.createElement("img",{src:"images/15.jpg"})),React.createElement("div",{className:"swiper-slide"},React.createElement("img",{src:"images/16.jpg"}))),React.createElement("div",{className:"swiper-pagination"}),React.createElement("div",{className:"swiper-button-prev"}),React.createElement("div",{className:"swiper-button-next"}),React.createElement("div",{className:"swiper-scrollbar"}))}});module.exports=BannerPlay});