
var maxHeight = 500;

AOS.init({
	startEvent:'load',
	offset: 200,
	easing: 'ease-out-back',
	duration: 750,
	disable: window.innerHeight < maxHeight,
});

( function( $ ) {
	
if($('body').hasClass('home') && window.innerHeight > maxHeight){
	AOS.refresh();
	$('.recent-posts article:nth-of-type(odd) .post-thumbnail').attr('data-aos','fade-left'); //setter
	$('.recent-posts article:nth-of-type(odd) .entry').attr('data-aos','fade-right').attr('data-aos-offset','300');; //setter

	$('.recent-posts article:nth-of-type(even) .post-thumbnail').attr('data-aos','fade-right'); //setter
	$('.recent-posts article:nth-of-type(even) .entry').attr('data-aos','fade-left').attr('data-aos-offset','300'); //setter
}
} )( jQuery );