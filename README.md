# Project Monitoring

A web-based monitoring system for managing and tracking CCTV devices across multiple locations, buildings, and floors in real-time.

## Features

- **Interactive Map** — Visual monitoring of CCTV locations on a real-time map
- **Multi-Building Support** — Manage indoor CCTV per building and floor with floor plan overlay
- **Outdoor CCTV** — Track outdoor CCTV markers with coordinates
- **Error Reporting** — Report and acknowledge CCTV errors with documentation
- **Maintenance Tracking** — Log maintenance activities with technician records
- **Threshold Alerts** — Configurable due and overdue maintenance thresholds
- **Real-time Notifications** — Audio and visual alerts for active CCTV errors
- **Role-based Access** — Multiple user roles (Super Admin, Manager, Technician, Security)
- **Activity Logs** — Complete log history with export to Excel
- **Customizable Settings** — Color themes, thresholds, and daily reset configuration

## Tech Stack

- **Backend** — Laravel 11, PostgreSQL
- **Frontend** — Tailwind CSS, Alpine.js, Leaflet.js
- **Map Tiles** — ESRI World Imagery
- **Auth** — Laravel Breeze

## Requirements

- PHP >= 8.2
- PostgreSQL >= 14
- Node.js >= 18
- Composer

## Installation

```bash
# Clone repository
git clone https://github.com/saddamhmn/Project_Monitoring.git
cd Project_Monitoring

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Configure database in .env, then:
php artisan migrate
php artisan db:seed

# Build assets
npm run build

# Storage link
php artisan storage:link
```

## Environment Variables

Key variables to configure in `.env`:
