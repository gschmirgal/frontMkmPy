function animateCounters() {
    const statsGrid = document.querySelector('.stats-grid');
    if (!statsGrid) return;
    const counters = statsGrid.querySelectorAll('.counter:not(.animated)');
    if (!counters.length) return;

    function animate(counter, target, duration = 2000) {
        const start = 0;
        const startTime = performance.now();
        function update(now) {
            const progress = Math.min((now - startTime) / duration, 1);
            const value = Math.floor(start + (target - start) * (1 - Math.pow(1 - progress, 4)));
            counter.textContent = value.toLocaleString();
            if (progress < 1) {
                requestAnimationFrame(update);
            } else {
                counter.textContent = target.toLocaleString();
                counter.classList.add('animated');
            }
        }
        requestAnimationFrame(update);
    }

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                counters.forEach((counter, i) => {
                    setTimeout(() => animate(counter, parseInt(counter.dataset.target)), i * 200);
                });
                observer.unobserve(statsGrid);
            }
        });
    }, { threshold: 0.5 });

    observer.observe(statsGrid);
}

document.addEventListener('DOMContentLoaded', animateCounters);
document.addEventListener('turbo:load', animateCounters);
document.addEventListener('turbo:render', animateCounters);
