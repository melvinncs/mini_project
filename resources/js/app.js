document.addEventListener('DOMContentLoaded', function() {
    // efek scroll navbar
    const navbar = document.getElementById('navbar');
    if (navbar) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    }

    // mobile menu toggle
    const menuToggle = document.getElementById('menuToggle');
    const navLinks = document.getElementById('navLinks');

    if (menuToggle && navLinks) {
        menuToggle.addEventListener('click', () => {
            menuToggle.classList.toggle('active');
            navLinks.classList.toggle('open');
        });

        document.querySelectorAll('.navbar-links a').forEach(link => {
            link.addEventListener('click', () => {
                menuToggle.classList.remove('active');
                navLinks.classList.remove('open');
            });
        });
    }

    // smooth scroll
    const navLinksAll = document.querySelectorAll('.nav-link');

    navLinksAll.forEach(link => {
        link.addEventListener('click', function(e) {
            const targetId = this.getAttribute('data-target');
            const targetElement = document.getElementById(targetId);

            if (targetElement) {
                e.preventDefault();
                const navbarHeight = navbar ? navbar.offsetHeight : 0;
                const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - navbarHeight;

                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });

    // highlight nav link aktif
    const sections = document.querySelectorAll('section[id]');
    const navLinkItems = document.querySelectorAll('.nav-link');

    if (sections.length > 0 && navLinkItems.length > 0) {
        window.addEventListener('scroll', () => {
            let current = '';
            const navbarHeight = navbar ? navbar.offsetHeight : 0;

            sections.forEach(section => {
                const sectionTop = section.offsetTop - navbarHeight - 100;
                if (window.scrollY >= sectionTop) {
                    current = section.getAttribute('id');
                }
            });

            navLinkItems.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('data-target') === current) {
                    link.classList.add('active');
                }
            });
        });
    }

    // active nav link current page
    const currentPath = window.location.pathname;
    const navLinksPage = document.querySelectorAll('.navbar-links a:not(.nav-link)');

    navLinksPage.forEach(link => {
        const href = link.getAttribute('href');
        if (href && href !== '#' && href !== '') {
            const linkPath = href.split('?')[0].split('#')[0];
            if (linkPath === currentPath) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        }
    });

    // Filter functionality untuk dashboard drama
    const filterInputs = document.querySelectorAll('.filter-input');
    const filterSelects = document.querySelectorAll('.filter-select');
    const filterBtns = document.querySelectorAll('.filter-btn');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const wrapper = this.closest('.filter-wrapper');
            const input = wrapper ? wrapper.querySelector('.filter-input') : null;
            const selects = wrapper ? wrapper.querySelectorAll('.filter-select') : [];

            const keyword = input ? input.value.toLowerCase() : '';
            const genre = selects.length > 0 ? selects[0].value : '';
            const year = selects.length > 1 ? selects[1].value : '';

            const parentGrid = wrapper ? wrapper.nextElementSibling : null;
            if (parentGrid) {
                const cards = parentGrid.querySelectorAll('.drama-card, .article-card');
                cards.forEach(card => {
                    let show = true;

                    if (keyword) {
                        const title = card.querySelector('h3') ? card.querySelector('h3').textContent.toLowerCase() : '';
                        if (!title.includes(keyword)) {
                            show = false;
                        }
                    }

                    if (genre && card.classList.contains('drama-card')) {
                        const genres = card.querySelectorAll('.genres span');
                        let hasGenre = false;
                        genres.forEach(g => {
                            if (g.textContent === genre) hasGenre = true;
                        });
                        if (!hasGenre) show = false;
                    }

                    if (year && card.classList.contains('drama-card')) {
                        const yearElement = card.querySelector('.meta span:first-child');
                        if (yearElement && yearElement.textContent !== year) {
                            show = false;
                        }
                    }

                    card.style.display = show ? '' : 'none';
                });
            }
        });
    });

    filterInputs.forEach(input => {
        input.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                const btn = this.closest('.filter-wrapper').querySelector('.filter-btn');
                if (btn) btn.click();
            }
        });
    });

    // PAGINATION FUNCTIONALITY
    const paginationBtns = document.querySelectorAll('.pagination-btn, .pagination-btn-number');
    paginationBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            if (this.classList.contains('active')) return;

            const wrapper = this.closest('.pagination-wrapper');
            const allBtns = wrapper ? wrapper.querySelectorAll('.pagination-btn, .pagination-btn-number') : [];

            allBtns.forEach(b => {
                b.classList.remove('active');
            });

            this.classList.add('active');

            const section = this.closest('.section');
            if (section) {
                const navbarHeight = navbar ? navbar.offsetHeight : 0;
                const sectionTop = section.getBoundingClientRect().top + window.pageYOffset - navbarHeight - 20;
                window.scrollTo({
                    top: sectionTop,
                    behavior: 'smooth'
                });
            }
        });
    });

    console.log('K-DramaHub script loaded successfully!');

    // NOTE: Fitur cari judul K-Drama (TMDB) di halaman Tambah/Edit Drama
    // ditangani sepenuhnya oleh script inline di tambahdrama.blade.php,
    // supaya tidak ada dua handler yang bentrok di elemen #cari_drama.
});

// ============================================
// FUNGSI UNTUK HALAMAN PUBLIC DRAMA
// ============================================
async function fetchDramas(query = 'korean drama', year = '2026') {
    try {
        const response = await fetch(`/api/dramas?q=${encodeURIComponent(query)}&year=${year}`);
        const data = await response.json();

        if (data.success) {
            renderDramas(data.data);
        } else {
            console.error('Failed to fetch dramas:', data.message);
            showErrorMessage('Gagal memuat data drama');
        }
    } catch (error) {
        console.error('Error fetching dramas:', error);
        showErrorMessage('Terjadi kesalahan saat memuat data');
    }
}

function renderDramas(dramas) {
    const grid = document.querySelector('.drama-grid');
    if (!grid) return;

    if (dramas.length === 0) {
        grid.innerHTML = `
            <div class="empty-state">
                <p>Tidak ada drama Korea yang ditemukan untuk tahun ini</p>
            </div>
        `;
        return;
    }

    let html = '';
    dramas.forEach(drama => {
        const badge = drama.rating >= 8.5 ? '🔥 Hot' :
                     drama.rating >= 7.5 ? '⭐ Populer' : '📺 Baru';
        const badgeClass = drama.rating >= 8.5 ? 'badge-hot' :
                          drama.rating >= 7.5 ? 'badge-populer' : 'badge-new';

        html += `
            <div class="drama-card" data-id="${drama.id}">
                <img class="poster" src="${drama.poster || 'https://via.placeholder.com/300x400?text=No+Image'}"
                     alt="${drama.title}" loading="lazy">
                <span class="badge-top ${badgeClass}">${badge}</span>
                <div class="info">
                    <h3>${drama.title}</h3>
                    <div class="meta">
                        <span>${drama.year || 'N/A'}</span>
                        <span>•</span>
                        <span class="rating">⭐ ${drama.rating ? drama.rating.toFixed(1) : 'N/A'}</span>
                        <span>•</span>
                        <span>${drama.episodes} Episode</span>
                    </div>
                    <div class="genres">
                        ${drama.genres.map(genre => `<span>${genre}</span>`).join('')}
                    </div>
                    <p class="sinopsis">${drama.summary ? drama.summary.substring(0, 150) + '...' : 'No synopsis available'}</p>
                    <div class="pemeran">
                        ${drama.cast && drama.cast.length > 0
                            ? drama.cast.map(actor => `<span>${actor.name}</span>`).join('')
                            : '<span>Cast not available</span>'
                        }
                    </div>
                    <div class="episode-info">
                        <span>📺 ${drama.episodes} Episode</span>
                        <span>⭐ ${drama.rating ? drama.rating.toFixed(1) : 'N/A'}/10</span>
                    </div>
                </div>
            </div>
        `;
    });

    grid.innerHTML = html;
    addDramaClickListeners();
}

function addDramaClickListeners() {
    document.querySelectorAll('.drama-card').forEach(card => {
        card.addEventListener('click', function() {
            const id = this.dataset.id;
            if (id) {
                fetchDramaDetailPublic(id);
            }
        });
    });
}

async function fetchDramaDetailPublic(id) {
    try {
        const response = await fetch(`/api/dramas/${id}`);
        const data = await response.json();

        if (data.success) {
            showDramaModal(data.data);
        } else {
            console.error('Failed to fetch drama detail:', data.message);
        }
    } catch (error) {
        console.error('Error fetching drama detail:', error);
    }
}

function showDramaModal(drama) {
    const modal = document.createElement('div');
    modal.className = 'drama-modal';
    modal.innerHTML = `
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <div class="modal-body">
                <div class="modal-poster">
                    <img src="${drama.poster_large || drama.poster || 'https://via.placeholder.com/300x400?text=No+Image'}"
                         alt="${drama.title}">
                </div>
                <div class="modal-info">
                    <h2>${drama.title}</h2>
                    <div class="modal-meta">
                        <span>📅 ${drama.year || 'N/A'}</span>
                        <span>⭐ ${drama.rating ? drama.rating.toFixed(1) : 'N/A'}/10</span>
                        <span>📺 ${drama.episodes} Episode</span>
                        <span>⏱️ ${drama.runtime || 'N/A'} min</span>
                    </div>
                    <div class="modal-genres">
                        ${drama.genres.map(genre => `<span>${genre}</span>`).join('')}
                    </div>
                    <div class="modal-synopsis">
                        <h4>Sinopsis</h4>
                        <p>${drama.summary || 'No synopsis available'}</p>
                    </div>
                    <div class="modal-cast">
                        <h4>Pemeran</h4>
                        <div class="cast-grid">
                            ${drama.cast && drama.cast.length > 0
                                ? drama.cast.map(actor => `
                                    <div class="cast-item">
                                        ${actor.image ? `<img src="${actor.image}" alt="${actor.name}">` : ''}
                                        <div>
                                            <strong>${actor.name}</strong>
                                            <p>${actor.character}</p>
                                        </div>
                                    </div>
                                `).join('')
                                : '<p>Cast not available</p>'
                            }
                        </div>
                    </div>
                    <div class="modal-network">
                        <p><strong>Network:</strong> ${drama.network || 'N/A'}</p>
                        ${drama.official_site ? `<p><strong>Official Site:</strong> <a href="${drama.official_site}" target="_blank">${drama.official_site}</a></p>` : ''}
                    </div>
                </div>
            </div>
        </div>
    `;

    document.body.appendChild(modal);

    modal.querySelector('.close-btn').addEventListener('click', () => {
        modal.remove();
    });

    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.remove();
        }
    });
}

function showErrorMessage(message) {
    const grid = document.querySelector('.drama-grid');
    if (grid) {
        grid.innerHTML = `
            <div class="error-state">
                <p>${message}</p>
                <button onclick="fetchDramas()" class="btn-primary">Coba Lagi</button>
            </div>
        `;
    }
}

// Load dramas on page load if drama grid exists
document.addEventListener('DOMContentLoaded', function() {
    const dramaGrid = document.querySelector('.drama-grid');
    if (dramaGrid) {
        fetchDramas();
    }

    // Filter functionality for public drama page
    const filterBtn = document.querySelector('.filter-btn');
    const searchInput = document.querySelector('.filter-input');
    const genreSelect = document.querySelector('.filter-select');
    const yearSelect = document.querySelectorAll('.filter-select')[1];

    if (filterBtn) {
        filterBtn.addEventListener('click', function() {
            const query = searchInput ? searchInput.value || 'korean drama' : 'korean drama';
            const genre = genreSelect ? genreSelect.value : '';
            const year = yearSelect ? yearSelect.value : '2026';

            let searchQuery = query;
            if (genre) {
                searchQuery += ` ${genre}`;
            }

            fetchDramas(searchQuery, year);
        });
    }

    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                filterBtn.click();
            }
        });
    }
});