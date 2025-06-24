// Theme and Language Manager
class AppManager {
  constructor() {
    this.currentLanguage = 'en';
    this.isDarkMode = false;
    this.init();
  }

  init() {
    this.loadSettings();
    this.setupEventListeners();
    this.setupIntersectionObserver();
    this.updateUI();
  }

  loadSettings() {
    // Load language preference
    this.currentLanguage = localStorage.getItem('language') || 'en';
    document.getElementById('languageSwitch').value = this.currentLanguage;

    // Load theme preference
    this.isDarkMode = localStorage.getItem('theme') === 'dark' || 
                     (window.matchMedia('(prefers-color-scheme: dark)').matches && !localStorage.getItem('theme'));
    document.documentElement.setAttribute('data-theme', this.isDarkMode ? 'dark' : '');
  }

  setupEventListeners() {
    // Language switch
    document.getElementById('languageSwitch').addEventListener('change', (e) => {
      this.currentLanguage = e.target.value;
      localStorage.setItem('language', this.currentLanguage);
      this.updateUI();
    });

    // Theme toggle
    document.getElementById('modeToggle').addEventListener('click', () => {
      this.isDarkMode = !this.isDarkMode;
      localStorage.setItem('theme', this.isDarkMode ? 'dark' : 'light');
      document.documentElement.setAttribute('data-theme', this.isDarkMode ? 'dark' : '');
      this.updateUI();
    });

    // Header scroll effect
    window.addEventListener('scroll', () => {
      const header = document.getElementById('mainHeader');
      if (window.scrollY > 50) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }
    });

    // Set active nav link based on current page
    this.setActiveNavLink();
  }

  setActiveNavLink() {
    const currentPage = window.location.pathname.split('/').pop() || 'index.html';
    document.querySelectorAll('.nav-links a').forEach(link => {
      const linkPage = link.getAttribute('href');
      if (currentPage === linkPage) {
        link.classList.add('active');
      } else {
        link.classList.remove('active');
      }
    });
  }

  setupIntersectionObserver() {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('in-view');
        }
      });
    }, { threshold: 0.2 });

    document.querySelectorAll('.card, .testimonial, .service-card, .animate').forEach(el => {
      observer.observe(el);
    });
  }

  updateUI() {
    // Update all multilingual elements
    document.querySelectorAll('[data-en], [data-fr], [data-ar]').forEach(el => {
      if (el.dataset[this.currentLanguage]) {
        if (el.tagName === 'INPUT') {
          el.placeholder = el.dataset[this.currentLanguage];
        } else {
          el.textContent = el.dataset[this.currentLanguage];
        }
      }
    });

    // Update RTL for Arabic
    document.documentElement.dir = this.currentLanguage === 'ar' ? 'rtl' : 'ltr';

    // Update theme toggle text
    this.updateThemeToggleText();
  }

  updateThemeToggleText() {
    const toggle = document.getElementById('modeToggle');
    if (!toggle) return;

    const icon = this.isDarkMode ? 'sun' : 'moon';
    const text = {
      en: this.isDarkMode ? 'Light Mode' : 'Dark Mode',
      fr: this.isDarkMode ? 'Mode Clair' : 'Mode Sombre',
      ar: this.isDarkMode ? 'الوضع الفاتح' : 'الوضع المظلم'
    }[this.currentLanguage];

    toggle.innerHTML = `<i class="fas fa-${icon}"></i> ${text}`;
  }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => new AppManager());

// Also initialize if page is already loaded
if (document.readyState === 'complete' || document.readyState === 'interactive') {
  new AppManager();
}