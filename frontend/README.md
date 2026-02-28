# Frontend

Vue 3 + Vite storefront for the KAV medical landing template.

## Commands

```bash
npm install
npm run dev
npm run build
```

## Runtime

Frontend loads content from Laravel API:

- `/api/settings`
- `/api/blocks`
- `/api/doctors`
- `/api/services`
- `/api/gallery`
- `/api/reviews`

Set `VITE_API_BASE_URL` only when frontend and backend live on different origins.
