export function initMobileMenu(root = document) {
    const toggle = root.querySelector('[data-mobile-menu-toggle]');
    const menu = root.querySelector('[data-mobile-menu]');

    if (!toggle || !menu || toggle.dataset.mobileMenuBound === 'true') {
        return;
    }

    toggle.dataset.mobileMenuBound = 'true';

    const setOpen = (open) => {
        menu.hidden = !open;
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        toggle.classList.toggle('is-open', open);
        document.body.classList.toggle('mobile-menu-open', open);
    };

    toggle.addEventListener('click', (event) => {
        event.preventDefault();
        event.stopPropagation();
        setOpen(Boolean(menu.hidden));
    });

    menu.querySelectorAll('[data-mobile-menu-close], .mobile-drawer__link, .mobile-drawer__cta').forEach((el) => {
        el.addEventListener('click', () => setOpen(false));
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !menu.hidden) {
            setOpen(false);
        }
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => initMobileMenu());
} else {
    initMobileMenu();
}
