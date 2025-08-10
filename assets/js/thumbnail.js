function bindHoverImage() {
  const hoverImg = document.getElementById('hover-img');
  document.querySelectorAll('.hover-link').forEach(link => {
    link.addEventListener('mouseenter', e => {
      hoverImg.src = link.dataset.img;
      hoverImg.style.display = 'block';
    });
    link.addEventListener('mousemove', e => {
      hoverImg.style.left = (e.clientX + 20) + 'px';
      hoverImg.style.top = (e.clientY + 20) + 'px';
    });
    link.addEventListener('mouseleave', e => {
      hoverImg.style.display = 'none';
    });
  });
}

bindHoverImage();
document.addEventListener('turbo:load', bindHoverImage);