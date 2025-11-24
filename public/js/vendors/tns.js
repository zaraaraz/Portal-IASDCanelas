// tiny slider

if (document.getElementById('product')) {
  const slider = tns({
    container: '#product',
    items: 1,
    startIndex: 1,
    navContainer: '#product-thumbnails',
    navAsThumbnails: true,
    autoplay: false,
    autoplayTimeout: 1000,
    swipeAngle: false,
    speed: 400,
    controls: false,
  });
}
