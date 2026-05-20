document.addEventListener('alpine:init', () => {

    Alpine.store('sidebar', {

        isExpanded: window.innerWidth >= 1280,
        isMobileOpen: false,
        isHovered: false,

        init() {

            window.addEventListener('resize', () => {

                if (window.innerWidth < 1280) {

                    this.isExpanded = false;
                    this.isHovered = false;

                } else {

                    this.isMobileOpen = false;
                }
            });
        },

        toggleExpanded() {

            if (window.innerWidth >= 1280) {

                this.isExpanded = !this.isExpanded;
            }
        },

        toggleMobileOpen() {

            if (window.innerWidth < 1280) {

                this.isMobileOpen = !this.isMobileOpen;
            }
        },

        setMobileOpen(value) {

            this.isMobileOpen = value;
        },

        closeMobile() {

            this.isMobileOpen = false;
        },

        setHovered(value) {

            if (!this.isExpanded && window.innerWidth >= 1280) {

                this.isHovered = value;

            } else {

                this.isHovered = false;
            }
        }
    });

});