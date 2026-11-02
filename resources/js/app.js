import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Global helper for 3D card tilt & glare
Alpine.data('posterTilt', () => ({
    rx: 0,
    ry: 0,
    glareX: '50%',
    glareY: '50%',
    handleMouseMove(e) {
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches || window.innerWidth < 1024) {
            return;
        }
        const card = e.currentTarget;
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        const centerX = rect.width / 2;
        const centerY = rect.height / 2;

        this.rx = ((y - centerY) / centerY) * -10;
        this.ry = ((x - centerX) / centerX) * 10;
        this.glareX = `${(x / rect.width) * 100}%`;
        this.glareY = `${(y / rect.height) * 100}%`;
    },
    handleMouseLeave() {
        this.rx = 0;
        this.ry = 0;
        this.glareX = '50%';
        this.glareY = '50%';
    }
}));

// Global countdown timer
Alpine.data('screeningCountdown', (targetDateStr) => ({
    target: new Date(targetDateStr).getTime(),
    hours: '00',
    minutes: '00',
    seconds: '00',
    timer: null,
    init() {
        this.update();
        this.timer = setInterval(() => this.update(), 1000);
    },
    update() {
        const now = new Date().getTime();
        const diff = this.target - now;
        if (diff <= 0) {
            this.hours = '00';
            this.minutes = '00';
            this.seconds = '00';
            if (this.timer) clearInterval(this.timer);
            return;
        }
        const h = Math.floor(diff / (1000 * 60 * 60));
        const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const s = Math.floor((diff % (1000 * 60)) / 1000);
        this.hours = String(h).padStart(2, '0');
        this.minutes = String(m).padStart(2, '0');
        this.seconds = String(s).padStart(2, '0');
    }
}));

// Trailer Modal Store
Alpine.store('trailerModal', {
    isOpen: false,
    loading: false,
    movie: {},
    trailer: {},
    storyboard: [],
    open(slug, trailerId = null) {
        this.isOpen = true;
        this.loading = true;
        const url = `/movies/${slug}/trailer` + (trailerId ? `?trailer_id=${trailerId}` : '');
        fetch(url)
            .then(res => res.json())
            .then(data => {
                this.movie = data.movie;
                this.trailer = data.trailer;
                this.storyboard = data.storyboard;
                this.loading = false;
            })
            .catch(err => {
                console.error('Failed to load trailer:', err);
                this.loading = false;
            });
    },
    close() {
        this.isOpen = false;
        this.movie = {};
        this.trailer = {};
        this.storyboard = [];
    }
});

// Phase 2 Showtime Slot-In Drawer Store
Alpine.store('showtimeDrawer', {
    isOpen: false,
    loading: false,
    slot: null,
    open(showtimeId) {
        this.isOpen = true;
        this.loading = true;
        fetch(`/showtimes/${showtimeId}/slot-preview`, {
            headers: { 'Accept': 'application/json' }
        })
            .then(res => res.json())
            .then(data => {
                this.slot = data;
                this.loading = false;
            })
            .catch(err => {
                console.error('Failed to load showtime slot preview:', err);
                this.loading = false;
            });
    },
    close() {
        this.isOpen = false;
        this.slot = null;
    }
});

// Watchlist Quick Action Store
Alpine.store('watchlist', {
    toggle(movieId) {
        fetch('/watchlist/toggle', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
                'Accept': 'application/json',
            },
            body: JSON.stringify({ movie_id: movieId })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Update badge
                const badges = document.querySelectorAll('.watchlist-counter-badge');
                badges.forEach(b => b.textContent = data.count);

                // Dispatch toast
                window.dispatchEvent(new CustomEvent('show-toast', {
                    detail: {
                        type: data.is_added ? 'success' : 'info',
                        title: data.is_added ? 'Watchlist' : 'Removed',
                        message: data.message
                    }
                }));
            }
        })
        .catch(err => console.error('Watchlist toggle error:', err));
    }
});

Alpine.start();
