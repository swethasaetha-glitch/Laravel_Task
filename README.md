# Track Tech Solutions - Garment Production Management System

A comprehensive textile & garment production management system developed in Laravel 12.

## Key Features

- **Authentication & User Management**: Secure Sign In (Login), User Registration (Sign Up), Role-Based access, and Logout.
- **Dashboard**: Live summary metrics (Total Fabrics, Fabric Groups, Lay Models, Bundles) and workflow pipeline diagram.
- **Fabric Master Module**: Full CRUD operations for raw textile fabrics (Fabric Code, Name, Type, Composition, Color, GSM, Width, Unit, Status, Soft Delete).
- **Fabric Group Module**: Many-to-many fabric assignment, group details, and fabric management.
- **Lay Model Module**: Garment laying and cutting configuration (Lay Length, Lay Width, Plies, Marker dimensions). Backend validation ensures selected fabric belongs to the selected fabric group.
- **Production Bundles Module**: Interactive modal creation, tracking bundle quantities (Total, Completed, Rejected), search and status filtering.
- **Automated Test Suite**: 29 Feature & Unit tests passing cleanly (86 assertions).

## Default Administrator Credentials

- **Email**: `admin@example.com`
- **Password**: `ChangeMe@123`

## Quick Setup Instructions

```bash
# 1. Install dependencies
composer install

# 2. Set up environment file
cp .env.example .env
php artisan key:generate

# 3. Run database migrations & test data seeders
php artisan migrate:fresh --seed

# 4. Run automated test suite
php artisan test

# 5. Start development server
php artisan serve
```
