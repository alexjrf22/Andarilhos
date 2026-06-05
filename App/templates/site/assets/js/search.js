const searchForm = document.getElementById('searchForm');
const searchInput = document.getElementById('searchQuery');
const searchSuggestions = document.getElementById('search-suggestions');
let searchTimeout = null;

function hideSuggestions() {
    if (searchSuggestions) {
        searchSuggestions.classList.add('hidden');
        searchSuggestions.innerHTML = '';
    }
}

function renderSuggestions(posts, postUrlBase) {
    if (!searchSuggestions) {
        return;
    }

    if (!posts || posts.length === 0) {
        searchSuggestions.classList.remove('hidden');
        searchSuggestions.innerHTML = '<div class="px-4 py-3 text-sm text-gray-300">Nenhum resultado encontrado.</div>';
        return;
    }

    const items = posts.map(post => {
        const title = post.post_title || 'Sem título';
        const postUrl = postUrlBase ? `${postUrlBase}/${post.post_id}` : `novagaia/post/${post.post_id}`;
        return `
            <a href="${postUrl}" class="block px-4 py-3 border-b border-gray-800 text-white hover:bg-gray-800 transition">
                <div class="font-semibold">${title}</div>
                <div class="text-xs text-gray-400">Clique para abrir o post</div>
            </a>
        `;
    }).join('');

    searchSuggestions.classList.remove('hidden');
    searchSuggestions.innerHTML = items;
}

function fetchSearchSuggestions(query, url, postUrlBase) {
    if (!url || query.trim() === '') {
        hideSuggestions();
        return;
    }

    fetch(`${url}?searchQuery=${encodeURIComponent(query)}`, {
        headers: {
            'Accept': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => renderSuggestions(data.results, postUrlBase))
        .catch(() => {
            hideSuggestions();
        });
}

if (searchForm && searchInput) {
    const searchUrl = searchForm.dataset.searchUrl || '/novagaia/busca/ajax';
    const postUrlBase = searchForm.dataset.postUrl || '/post';

    searchInput.addEventListener('input', () => {
        clearTimeout(searchTimeout);
        const query = searchInput.value.trim();
        if (query === '') {
            hideSuggestions();
            return;
        }

        searchTimeout = setTimeout(() => {
            fetchSearchSuggestions(query, searchUrl, postUrlBase);
        }, 250);
    });

    searchForm.addEventListener('submit', function(event) {
        const query = searchInput.value.trim();
        if (!query) {
            event.preventDefault();
            searchInput.focus();
            hideSuggestions();
            return;
        }

        hideSuggestions();
    });
}

if (searchSuggestions) {
    searchSuggestions.addEventListener('click', event => {
        event.stopPropagation();
    });
}
