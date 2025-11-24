@extends('layouts.app')

@section('title', 'Posts — JSONPlaceholder')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Posts</h1>
            <p class="text-muted mb-0">Data from JSONPlaceholder (demo API)</p>
        </div>

        <div class="d-flex gap-2">
            <input id="searchInput" type="search" class="form-control" placeholder="Search title or body..." style="min-width:320px;">
            <select id="perPage" class="form-select" style="width:120px;">
                <option value="5">5 / page</option>
                <option value="10" selected>10 / page</option>
                <option value="20">20 / page</option>
                <option value="50">50 / page</option>
            </select>
        </div>
    </div>

    @if(!empty($error))
        <div class="alert alert-danger">{{ $error }}</div>
    @endif

    <div id="postsGrid" class="row g-3">
        {{-- JS will render cards here --}}
    </div>

    <nav class="mt-4 d-flex justify-content-between align-items-center">
        <div id="resultsInfo" class="text-muted"></div>
        <ul id="pagination" class="pagination mb-0"></ul>
    </nav>
</div>

{{-- Template for a single post card (hidden) --}}
<template id="postCardTpl">
    <div class="col-12 col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title mb-2 small text-truncate"></h5>
                <p class="card-text mb-3 small text-muted" style="flex:1;"></p>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <small class="text-secondary">User <span class="userId small"></span></small>
                    <button class="btn btn-sm btn-outline-primary viewBtn">View</button>
                </div>
            </div>
        </div>
    </div>
</template>

@endsection

@section('scripts')
<script>
(() => {
    // Data passed from server
    const posts = @json($posts ?? []);
    // State
    let filtered = posts.slice();
    let currentPage = 1;
    let perPage = parseInt(document.getElementById('perPage').value, 10);

    // Elements
    const grid = document.getElementById('postsGrid');
    const tpl = document.getElementById('postCardTpl');
    const searchInput = document.getElementById('searchInput');
    const perPageSelect = document.getElementById('perPage');
    const pagination = document.getElementById('pagination');
    const resultsInfo = document.getElementById('resultsInfo');

    // Render helpers
    function renderPage(page = 1) {
        currentPage = page;
        perPage = parseInt(perPageSelect.value, 10);

        const start = (page - 1) * perPage;
        const end = start + perPage;
        const pageItems = filtered.slice(start, end);

        grid.innerHTML = '';

        if (pageItems.length === 0) {
            grid.innerHTML = '<div class="col-12"><div class="alert alert-muted">No posts match your search.</div></div>';
            renderPagination();
            updateInfo();
            return;
        }

        for (const post of pageItems) {
            const node = tpl.content.cloneNode(true);
            node.querySelector('.card-title').textContent = `#${post.id} — ${post.title}`;
            node.querySelector('.card-text').textContent = post.body;
            node.querySelector('.userId').textContent = post.userId;
            const btn = node.querySelector('.viewBtn');
            btn.addEventListener('click', () => showModal(post));
            grid.appendChild(node);
        }

        renderPagination();
        updateInfo();
    }

    function renderPagination() {
        pagination.innerHTML = '';
        const total = filtered.length;
        const pages = Math.max(1, Math.ceil(total / perPage));

        // simple prev button
        const makePageItem = (label, page, disabled=false, active=false) => {
            const li = document.createElement('li');
            li.className = 'page-item' + (disabled ? ' disabled' : '') + (active ? ' active' : '');
            const a = document.createElement('a');
            a.className = 'page-link';
            a.href = '#';
            a.textContent = label;
            a.addEventListener('click', (e) => { e.preventDefault(); if (!disabled) renderPage(page); });
            li.appendChild(a);
            return li;
        };

        pagination.appendChild(makePageItem('«', Math.max(1, currentPage-1), currentPage === 1));

        // show up to 7 page numbers centered on current
        const maxButtons = 7;
        const half = Math.floor(maxButtons / 2);
        let start = Math.max(1, currentPage - half);
        let end = Math.min(pages, start + maxButtons - 1);
        if (end - start < maxButtons - 1) start = Math.max(1, end - maxButtons + 1);

        for (let p = start; p <= end; p++) {
            pagination.appendChild(makePageItem(p, p, false, p === currentPage));
        }

        pagination.appendChild(makePageItem('»', Math.min(pages, currentPage+1), currentPage === pages));
    }

    function updateInfo() {
        const total = filtered.length;
        const start = total === 0 ? 0 : (currentPage - 1) * perPage + 1;
        const end = Math.min(total, currentPage * perPage);
        resultsInfo.textContent = `${start}-${end} of ${total} posts`;
    }

    // search/filter
    function applySearch() {
        const q = searchInput.value.trim().toLowerCase();
        if (q === '') {
            filtered = posts.slice();
        } else {
            filtered = posts.filter(p =>
                (p.title && p.title.toLowerCase().includes(q)) ||
                (p.body && p.body.toLowerCase().includes(q)) ||
                (String(p.userId).includes(q))
            );
        }
        // reset to page 1
        renderPage(1);
    }

    // modal for detail (simple)
    function showModal(post) {
        // create bootstrap modal dynamically
        const modalId = 'postModal';
        let modalEl = document.getElementById(modalId);
        if (!modalEl) {
            modalEl = document.createElement('div');
            modalEl.id = modalId;
            modalEl.className = 'modal fade';
            modalEl.tabIndex = -1;
            modalEl.innerHTML = `
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body"></div>
                    </div>
                </div>
            `;
            document.body.appendChild(modalEl);
        }

        modalEl.querySelector('.modal-title').textContent = `#${post.id} — ${post.title}`;
        modalEl.querySelector('.modal-body').innerHTML = `<p>${post.body}</p><p class="text-muted">User ID: ${post.userId}</p>`;

        const bsModal = new bootstrap.Modal(modalEl);
        bsModal.show();
    }

    // event listeners
    searchInput.addEventListener('input', () => {
        // small debounce
        clearTimeout(searchInput._deb);
        searchInput._deb = setTimeout(applySearch, 250);
    });

    perPageSelect.addEventListener('change', () => renderPage(1));

    // initial render
    renderPage(1);
})();
</script>

{{-- Include Bootstrap 5 JS if layout doesn't already load it --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
@endsection
