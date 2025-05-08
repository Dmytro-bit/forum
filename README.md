# Forum App
<p align="center">
</p>
<p align="center">
    <img src="https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel Logo"/> 
    <img src="https://img.shields.io/badge/-ReactJs-61DAFB?logo=react&logoColor=white&style=for-the-badge&color=black" alt="React Logo"/> 
    <img src="https://img.shields.io/badge/tailwindcss-%2338B2AC.svg?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwindcss Logo"/> 
    <img src="https://img.shields.io/badge/javascript-%23323330.svg?style=for-the-badge&logo=javascript&logoColor=%23F7DF1E" alt="Javascript Logo"/>
    <img src="https://img.shields.io/badge/MySQL-003545?style=for-the-badge&logo=mariadb&logoColor=white" alt="MariaDB Logo"/>
</p>
A real-time discussion forum built with Laravel, Inertia.js, React, Tailwind CSS, and Bootstrap. Users can create threads, post messages, and see new posts appear instantly via WebSockets (Pusher).

---

## Features

* **Thread Index**: Browse all discussion threads with reply counts and last activity timestamps.
* **Thread Detail**: Read and post messages in a thread. Messages include author, avatar, timestamp, and body.
* **Real-Time Updates**: New posts are broadcast to all viewers instantly using Pusher or Laravel WebSockets.
* **Responsive UI**: Styled with Tailwind CSS for layout and Bootstrap for components.
* **Chat-GPT**: Integrated AI-assistance functionality using OpenAI's API for real-time responses.

---

## Technologies

* **Backend**: Laravel 10+
* **Frontend**: React via Inertia.js
* **Styling**: Tailwind CSS & Bootstrap
* **WebSockets**: Pusher or Laravel WebSockets (beyondcode/laravel-websockets)
* **AI assistant**: ChatGPT API
* **Build Tool**: Vite

---

## Getting Started

### 1. Clone and install dependencies

```bash
git clone <repository-url> forum-app
cd forum-app
composer install
npm install
```

### 2. Environment

Copy the example `.env` and generate an app key:

```bash
cp .env.example .env
php artisan key:generate
```

#### Required `.env` variables

```dotenv
APP_NAME="ForumApp"
APP_ENV=local
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=forum
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=pusher
PUSHER_APP_ID=your_id
PUSHER_APP_KEY=your_key
PUSHER_APP_SECRET=your_secret
PUSHER_APP_CLUSTER=mt1

# Vite exposes these to the client
VITE_PUSHER_APP_KEY=
VITE_PUSHER_APP_CLUSTER=

QUEUE_CONNECTION=sync
OPENAI_API_KEY=
```

> **Note:** If using Laravel WebSockets, set `BROADCAST_DRIVER=pusher` and configure `.env` for local server (host/port).

### 3. Database Migrations & Seeders

```bash
php artisan migrate
php artisan db:seed     # optional: seed default data
```

### 4. Build Frontend Assets

```bash
npm run dev             # local dev with hot reload
npm run build           # production build (outputs to public/)
```

### 5. Serve the App

```bash
php artisan serve       # runs at http://127.0.0.1:8000
# and run WebSocket server if using laravel-websockets
php artisan websockets:serve
```

---

## Real-Time Broadcasting

1. **Create & Fire Event**

    * `app/Events/PostCreated.php` implements `ShouldBroadcast` (or `ShouldBroadcastNow`).
    * Broadcasts on channel `thread.{id}` with payload `{ id, author, body, created_at }`.
2. **Client Setup**

    * Install `pusher-js` and `laravel-echo`.
    * In `resources/js/bootstrap.js`, initialize Echo:

      ```js
      import Echo from 'laravel-echo';
      import Pusher from 'pusher-js';
      window.Pusher = Pusher;
      window.Echo = new Echo({
        broadcaster: 'pusher',
        key: import.meta.env.VITE_PUSHER_APP_KEY,
        cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
        forceTLS: true,
      });
      ```
    * Import `bootstrap.js` in `resources/js/app.jsx` before rendering the Inertia app.
    * Subscribe in `ThreadShow.jsx`:

      ```js
      useEffect(() => {
        const channel = window.Echo.channel(`thread.${thread.id}`);
        channel.listen('PostCreated', e => setLivePosts(prev => [...prev, e]));
        return () => window.Echo.leaveChannel(`thread.${thread.id}`);
      }, [thread.id]);
      ```

---

## Folder Structure

```
/app
  /Events
    PostCreated.php
  /Http/Controllers
    ThreadController.php
  /Models
    Thread.php
    Post.php
/resources
  /js
    /Pages
      Forum/Index.jsx
      Forum/Show.jsx
    app.jsx
    bootstrap.js
  /css/app.css
/routes/web.php
/vite.config.js
```

---

## Common Commands

* **Cache Clear**: `php artisan config:clear && php artisan cache:clear`
* **Queue Work**: `php artisan queue:work`
* **WebSockets**: `php artisan websockets:serve`
* **Build**: `npm run build`

---

## Contributing

Feel free to open issues or submit pull requests. Please follow PSR-12 standards for PHP and consistent code styling for JS (Prettier).

---
