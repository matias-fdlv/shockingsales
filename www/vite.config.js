import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/plantilla.css',
        'resources/css/adminStyle.css',
        'resources/css/registroAdmin.css',
        'resources/css/registroUsuario.css'

      ],
      refresh: true,
    }),
  ],
  server: {
    host: true,         // 0.0.0.0 dentro del contenedor
    port: 5173,
    strictPort: true,
    hmr: {
      protocol: 'http',
      host: 'localhost', // <-- el host que usa tu navegador: localhost o 127.0.0.1 (o tu dominio/IP)
      port: 5173,
    },
  },
})
