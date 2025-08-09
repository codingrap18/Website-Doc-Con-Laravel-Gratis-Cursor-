import './bootstrap';
import Alpine from 'alpinejs';
import Chart from 'chart.js/auto';

// Initialize Alpine.js
window.Alpine = Alpine;

// Sidebar global store to reliably toggle from anywhere
Alpine.store('sidebar', {
    open: window.innerWidth >= 1024,
    toggle() {
        this.open = !this.open;
    },
    close() {
        this.open = false;
    }
});

// Dark mode theme toggle functionality
Alpine.data('theme', () => ({
    dark: localStorage.getItem('theme') === 'dark' ||
          (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches),

    toggle() {
        this.dark = !this.dark;
        localStorage.setItem('theme', this.dark ? 'dark' : 'light');
        document.documentElement.classList.toggle('dark', this.dark);
    },

    init() {
        document.documentElement.classList.toggle('dark', this.dark);
    }
}));

// Sidebar functionality
// Keep sidebar responsive on resize
window.addEventListener('resize', () => {
    if (window.innerWidth < 1024) {
        Alpine.store('sidebar').open = false;
    } else {
        Alpine.store('sidebar').open = true;
    }
});

// Real-time clock component
Alpine.data('clock', () => ({
    time: new Date().toLocaleTimeString(),
    date: new Date().toLocaleDateString('en-US', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    }),

    init() {
        setInterval(() => {
            const now = new Date();
            this.time = now.toLocaleTimeString();
            this.date = now.toLocaleDateString('en-US', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }, 1000);
    }
}));

// Notification system
Alpine.data('notifications', () => ({
    unreadCount: 0,
    notifications: [],
    showDropdown: false,

    async fetchUnreadCount() {
        try {
            const response = await fetch('/api/notifications/unread-count');
            const data = await response.json();
            this.unreadCount = data.count;
        } catch (error) {
            console.error('Error fetching notification count:', error);
        }
    },

    async markAsRead(notificationId) {
        try {
            await fetch(`/api/notifications/${notificationId}/read`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                }
            });
            this.fetchUnreadCount();
        } catch (error) {
            console.error('Error marking notification as read:', error);
        }
    },

    async markAllAsRead() {
        try {
            await fetch('/api/notifications/mark-all-read', {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                }
            });
            this.unreadCount = 0;
        } catch (error) {
            console.error('Error marking all notifications as read:', error);
        }
    },

    init() {
        this.fetchUnreadCount();
        // Refresh count every 30 seconds
        setInterval(() => {
            this.fetchUnreadCount();
        }, 30000);
    }
}));

// Chart.js helper functions with theme support
window.createChart = function(ctx, config) {
    const isDark = document.documentElement.classList.contains('dark');

    // Theme-aware colors
    const colors = {
        light: {
            primary: '#3B82F6',
            secondary: '#14B8A6',
            success: '#10B981',
            warning: '#F59E0B',
            danger: '#EF4444',
            background: '#FFFFFF',
            surface: '#F8FAFC',
            text: '#1F2937',
            grid: '#E5E7EB'
        },
        dark: {
            primary: '#60A5FA',
            secondary: '#10B981',
            success: '#34D399',
            warning: '#FBBF24',
            danger: '#F87171',
            background: '#1F2937',
            surface: '#374151',
            text: '#F9FAFB',
            grid: '#4B5563'
        }
    };

    const theme = isDark ? colors.dark : colors.light;

    // Apply theme colors to config
    if (config.data && config.data.datasets) {
        config.data.datasets.forEach((dataset, index) => {
            if (!dataset.backgroundColor) {
                const colorKeys = Object.keys(theme).filter(key => !['background', 'surface', 'text', 'grid'].includes(key));
                dataset.backgroundColor = theme[colorKeys[index % colorKeys.length]];
            }
            if (!dataset.borderColor && dataset.backgroundColor) {
                dataset.borderColor = dataset.backgroundColor;
            }
        });
    }

    // Apply theme to options
    if (config.options) {
        if (config.options.plugins && config.options.plugins.legend) {
            config.options.plugins.legend.labels = {
                ...config.options.plugins.legend.labels,
                color: theme.text
            };
        }

        if (config.options.scales) {
            Object.keys(config.options.scales).forEach(scaleKey => {
                const scale = config.options.scales[scaleKey];
                scale.grid = {
                    ...scale.grid,
                    color: theme.grid
                };
                scale.ticks = {
                    ...scale.ticks,
                    color: theme.text
                };
            });
        }
    }

    return new Chart(ctx, config);
};

// Filter functionality
Alpine.data('filters', () => ({
    showFilters: false,

    toggleFilters() {
        this.showFilters = !this.showFilters;
    },

    clearFilters() {
        // Reset all form inputs
        const form = this.$refs.filterForm;
        if (form) {
            form.reset();
            form.submit();
        }
    }
}));

// Bulk actions functionality
Alpine.data('bulkActions', () => ({
    selectedItems: [],
    showBulkActions: false,

    toggleItem(id) {
        const index = this.selectedItems.indexOf(id);
        if (index > -1) {
            this.selectedItems.splice(index, 1);
        } else {
            this.selectedItems.push(id);
        }
        this.showBulkActions = this.selectedItems.length > 0;
    },

    toggleAll(items) {
        if (this.selectedItems.length === items.length) {
            this.selectedItems = [];
        } else {
            this.selectedItems = [...items];
        }
        this.showBulkActions = this.selectedItems.length > 0;
    },

    isSelected(id) {
        return this.selectedItems.includes(id);
    },

    getSelectedCount() {
        return this.selectedItems.length;
    }
}));

Alpine.start();
