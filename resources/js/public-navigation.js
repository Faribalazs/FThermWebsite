export default function registerPublicNavigation(Alpine) {
    Alpine.data('publicNavigation', () => ({
        mobileMenu: false,
        languageOpen: false,
        menuTransitionId: 0,
        init() {
            this.$watch('mobileMenu', (open) => this.transitionMobileMenu(open));

            this.onHashChange = () => this.updateActiveTab();
            window.addEventListener('hashchange', this.onHashChange);
            this.updateActiveTab();

            this.desktopQuery = window.matchMedia('(min-width: 1280px)');
            this.onDesktopChange = () => {
                if (this.desktopQuery.matches) this.mobileMenu = false;
            };
            this.desktopQuery.addEventListener('change', this.onDesktopChange);

            this.viewportHeight = window.innerHeight;
            this.onViewportChange = () => {
                const editing = document.activeElement?.matches('input:not([type="hidden"]), textarea, [contenteditable="true"]');
                if (!editing) this.viewportHeight = window.innerHeight;
                const visibleHeight = window.visualViewport?.height ?? window.innerHeight;
                document.body.classList.toggle('mobile-keyboard-open', Boolean(editing && visibleHeight < this.viewportHeight - 140));
            };
            this.onFocusChange = () => requestAnimationFrame(this.onViewportChange);
            window.visualViewport?.addEventListener('resize', this.onViewportChange);
            window.addEventListener('resize', this.onViewportChange);
            document.addEventListener('focusin', this.onFocusChange);
            document.addEventListener('focusout', this.onFocusChange);
        },
        async transitionMobileMenu(open) {
            const dialog = this.$refs.mobileDialog;
            const transitionId = ++this.menuTransitionId;

            if (open) {
                this.languageOpen = false;
                if (!dialog.open) {
                    this.previousOverflow = document.documentElement.style.overflow;
                    dialog.dataset.state = 'closed';
                    dialog.showModal();
                    document.documentElement.style.overflow = 'hidden';
                    // Establish the offscreen position before starting the entrance transition.
                    dialog.querySelector('.site-mobile-menu__panel').getBoundingClientRect();
                }
                dialog.dataset.state = 'open';
                return;
            }

            dialog.dataset.state = 'closing';
            // Keep the modal, backdrop and scroll lock until the exit transition finishes.
            await Promise.allSettled(dialog.getAnimations({ subtree: true }).map((animation) => animation.finished));
            if (transitionId !== this.menuTransitionId || this.mobileMenu) return;

            dialog.close();
            dialog.dataset.state = 'closed';
            document.documentElement.style.overflow = this.previousOverflow ?? '';
        },
        updateActiveTab() {
            const nav = document.querySelector('[data-mobile-nav][data-home-page="true"]');
            if (!nav) return;
            const onServices = window.location.hash === '#services';
            nav.querySelectorAll('[data-destination]').forEach((link) => {
                const active = link.dataset.destination === (onServices ? 'services' : 'home');
                if (active) link.setAttribute('aria-current', onServices ? 'location' : 'page');
                else link.removeAttribute('aria-current');
            });
        },
        destroy() {
            this.menuTransitionId++;
            window.removeEventListener('hashchange', this.onHashChange);
            this.desktopQuery.removeEventListener('change', this.onDesktopChange);
            window.visualViewport?.removeEventListener('resize', this.onViewportChange);
            window.removeEventListener('resize', this.onViewportChange);
            document.removeEventListener('focusin', this.onFocusChange);
            document.removeEventListener('focusout', this.onFocusChange);
            if (this.$refs.mobileDialog.open) {
                this.$refs.mobileDialog.close();
                document.documentElement.style.overflow = this.previousOverflow ?? '';
            }
            document.body.classList.remove('mobile-keyboard-open');
        },
    }));
}
