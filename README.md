# 🛡️ OrcInventory

*A Tool & Equipment Tracker*

Rugged, simple, strong — like an Orc guarding a gate.

Great for garages, workshops, and hobbyists.

## Features

- **Item Categories** - Organize your inventory with customizable categories and color coding
- **Barcodes & QR Codes** - Automatic generation for easy item tracking and quick access
- **Stock Levels** - Track inventory with low stock alerts and minimum level monitoring
- **Maintenance Logs** - Keep detailed records of repairs, inspections, and maintenance with cost tracking
- **Consumables Tracking** - Monitor usage and automatically update stock levels when items are used
- **Tool Check-in/Check-out** - Track who has what tools and when, with full checkout history
- **Dark Mode** - Toggle between light and dark themes for comfortable viewing
- **Mobile Responsive** - Full mobile support with responsive navigation and touch-friendly interface
- **Dashboard Overview** - Quick view of recent items, low stock alerts, and checked out tools

Perfect for anyone who loses tools the moment they put them down.

## Requirements

- PHP 8.2 or higher
- Composer
- Node.js and npm
- SQLite (default) or MySQL/PostgreSQL

## Installation

1. Clone the repository
2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install Node dependencies:
   ```bash
   npm install
   ```

4. Copy the environment file:
   ```bash
   cp .env.example .env
   ```

5. Generate application key:
   ```bash
   php artisan key:generate
   ```

6. Run migrations and seed the database (optional, but recommended for testing):
   ```bash
   php artisan migrate:fresh --seed
   ```
   
   Or just run migrations:
   ```bash
   php artisan migrate
   ```

7. Build assets:
   ```bash
   npm run build
   ```

8. Start the development server:
   ```bash
   php artisan serve
   ```

## Seeding Sample Data

The seeder creates sample data to help you get started:

- **Admin User**: `admin@orcinventory.com` / `password`
- **5 Additional Users** for testing
- **8 Categories** (Power Tools, Hand Tools, Fasteners, etc.)
- **50+ Items** (mix of tools and consumables)
- **Maintenance Logs**, **Checkouts**, and **Consumable Records**

To seed the database:
```bash
php artisan db:seed
```

Or to reset and reseed:
```bash
php artisan migrate:fresh --seed
```

## Usage

1. **Register a new account** or log in with the seeded admin account (`admin@orcinventory.com` / `password`)
2. **Create categories** for your items with custom colors for easy organization
3. **Add items** to your inventory with stock levels, locations, and descriptions
4. **Use QR codes and barcodes** for quick access - each item gets a unique QR code automatically
5. **Track tool checkouts** - check out tools to users and see who has what
6. **Record consumable usage** - track when consumables are used and stock levels update automatically
7. **Log maintenance activities** - record repairs, inspections, and maintenance with costs
8. **Toggle theme** - switch between light and dark mode using the theme toggle button
9. **Monitor dashboard** - view recent items, low stock alerts, and checked out tools at a glance

## Technology Stack

- **Laravel 12** - PHP framework
- **Tailwind CSS 4** - Modern utility-first CSS framework with dark mode support
- **SimpleSoftwareIO/simple-qrcode** - QR code generation
- **SQLite** - Database (default, can be switched to MySQL/PostgreSQL)
- **Vite** - Fast build tool for assets

## Development

To run the development server with hot reloading:
```bash
npm run dev
```

In another terminal:
```bash
php artisan serve
```

## Project Structure

- `app/Models/` - Eloquent models (Item, Category, Checkout, MaintenanceLog, Consumable)
- `app/Http/Controllers/` - Application controllers
- `database/factories/` - Model factories for seeding
- `database/seeders/` - Database seeders
- `resources/views/` - Blade templates
- `routes/web.php` - Application routes

## License

The MIT License (MIT). Please see the License File for more information.
