/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  safelist: [
    'bg-green-100', 'text-green-800',
    'bg-red-100', 'text-red-800',
    'bg-yellow-100', 'text-yellow-800',
    'bg-orange-100', 'text-orange-800',
    'bg-gray-100', 'text-gray-800',
  ],
  theme: {
    extend: {
      // ========================================
      // WARNA PINK CUSTOM
      // ========================================
      colors: {
        pink: {
          50: '#fdf2f8',
          100: '#fce7f3',
          200: '#fbcfe8',
          300: '#f9a8d4',
          400: '#f472b6',
          500: '#ec4899',
          600: '#db2777',
          700: '#be185d',
          800: '#9d174d',
          900: '#831843',
        },
      },

      // ========================================
      // ANIMASI CUSTOM
      // ========================================
      animation: {
        'blob': 'blob 20s infinite ease-in-out',
        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
        'float': 'float 6s ease-in-out infinite',
        'spin-slow': 'spin 3s linear infinite',
        'fade-in': 'fadeIn 0.5s ease-out',
        'slide-down': 'slideDown 0.3s ease-out',
      },
      keyframes: {
        blob: {
          '0%': { transform: 'translate(0px, 0px) scale(1)' },
          '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
          '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
          '100%': { transform: 'translate(0px, 0px) scale(1)' },
        },
        float: {
          '0%, 100%': { transform: 'translateY(0px)' },
          '50%': { transform: 'translateY(-10px)' },
        },
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        slideDown: {
          '0%': { opacity: '0', transform: 'translateY(-10px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
      },

      // ========================================
      // GLASSMORPHISM UTILITY (Opsional)
      // ========================================
      backgroundColor: {
        'glass': 'rgba(255, 255, 255, 0.15)',
        'glass-dark': 'rgba(255, 255, 255, 0.08)',
        'glass-light': 'rgba(255, 255, 255, 0.25)',
      },
      borderColor: {
        'glass-border': 'rgba(255, 255, 255, 0.3)',
      },
      boxShadow: {
        'glass': '0 8px 32px rgba(0, 0, 0, 0.08)',
        'glass-hover': '0 12px 48px rgba(244, 114, 182, 0.25)',
        'pink-glow': '0 0 30px rgba(244, 114, 182, 0.15)',
      },
    },
  },
  plugins: [],
}