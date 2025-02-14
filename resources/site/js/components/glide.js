import Glide from '@glidejs/glide';

if (document.querySelector('.glide-hero')) {
    new Glide('.glide-hero', {
        type: 'carousel',
        gap: 10,
        autoplay: 5000,
        perView: 1,
        focusAt: 'center',
    }).mount();
}