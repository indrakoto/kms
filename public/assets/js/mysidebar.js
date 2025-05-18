function toggleSubMenu(subMenuId, clickedElement) {
    const subMenu = document.getElementById(subMenuId);
    
    // Tutup semua submenu lainnya
    document.querySelectorAll('.sub-menu-container').forEach(menu => {
        if (menu.id !== subMenuId) {
            menu.classList.remove('show');
            const parentMenu = menu.previousElementSibling;
            if (parentMenu && parentMenu.classList.contains('menu-parent')) {
                parentMenu.classList.remove('active');
                parentMenu.style.borderRadius = '30px';
            }
        }
    });
    
    // Toggle submenu yang diklik
    subMenu.classList.toggle('show');
    clickedElement.classList.toggle('active');
    
    // Sesuaikan border radius
    if (subMenu.classList.contains('show')) {
        clickedElement.style.borderRadius = '30px';
    } else {
        clickedElement.style.borderRadius = '30px';
    }
    
    // Toggle arrow icon
    const arrow = clickedElement.querySelector('.menu-arrow');
    if (arrow) {
        arrow.style.transform = subMenu.classList.contains('show') ? 'rotate(180deg)' : 'rotate(0)';
    }
}

// Buka submenu aktif saat page load
document.addEventListener('DOMContentLoaded', function() {
    const activeSubMenuItem = document.querySelector('.sub-menu-item.active');
    if (activeSubMenuItem) {
        const subMenu = activeSubMenuItem.closest('.sub-menu-container');
        if (subMenu) {
            subMenu.classList.add('show');
            const menuParent = subMenu.previousElementSibling;
            if (menuParent) {
                menuParent.classList.add('active');
                //menuParent.style.borderRadius = '30px 30px 0 0';
                menuParent.style.borderRadius = '30px';
                const arrow = menuParent.querySelector('.menu-arrow');
                if (arrow) {
                    arrow.style.transform = 'rotate(180deg)';
                }
            }
        }
    }
});