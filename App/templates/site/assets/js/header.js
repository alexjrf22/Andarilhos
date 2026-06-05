    // Menu mobile
    document.getElementById('mobile-btn')?.addEventListener('click', () => {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });

    // Search toggle in header
    const searchToggle = document.getElementById('search-toggle');
    const searchBox = document.getElementById('search-box');

    searchToggle?.addEventListener('click', (event) => {
        event.stopPropagation();
        searchBox?.classList.toggle('hidden');
        if (!searchBox?.classList.contains('hidden')) {
            setTimeout(() => document.getElementById('searchQuery')?.focus(), 50);
        }
    });

    document.addEventListener('click', (event) => {
        if (!searchBox?.contains(event.target) && !searchToggle?.contains(event.target)) {
            searchBox?.classList.add('hidden');
        }
    });

    searchBox?.addEventListener('click', (event) => {
        event.stopPropagation();
    });