import Glide from '@glidejs/glide';

if (document.querySelector('.glide-hero')) {
    new Glide('.glide-hero', {
        type: 'carousel',
        gap: 100,
        // autoplay: 2000,
        perView: 1,
        focusAt: 'center',
    }).mount();
}