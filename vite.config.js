import { defineConfig } from 'vite';
import { resolve } from 'path';

export default defineConfig({
  root: 'src',
  base: './',
  publicDir: '../public',

  build: {
    outDir: '../assets',
    emptyOutDir: true,
    manifest: true,
    rollupOptions: {
      input: {
        main: resolve(__dirname, 'src/js/main.js'),
        styles: resolve(__dirname, 'src/scss/main.scss'),
      },
      output: {
        entryFileNames: 'js/[name].js',
        chunkFileNames: 'js/[name]-[hash].js',
        assetFileNames: (assetInfo) => {
          if (assetInfo.name.endsWith('.css')) {
            return 'css/[name][extname]';
          }
          return 'images/[name][extname]';
        },
      },
    },
  },

  css: {
    devSourcemap: true,
  },

  server: {
    origin: 'http://localhost:5173',
  },
});
