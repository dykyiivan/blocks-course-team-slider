const initSlider = ()=>{
	const initSliders = document.querySelectorAll('.swiper');
	initSliders.forEach((slider)=>{
		const sliderLength = slider.children[0].children.length
		const result = (sliderLength > 1) ? true : false
		// eslint-disable-next-line
		const swiper = new Swiper(slider, {
			slidesPerView: 2,
			spaceBetween: 50,
			loop: result,
		});
	})
}
window.addEventListener('DOMContentLoaded', initSlider);



