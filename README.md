# Laravel Project Setup Guide

This document provides a step-by-step guide to setting up the Laravel project locally.

## Requirements

- PHP >= 8.3
- Composer
- MySQL >= 8.0
- Laravel CLI (optional but helpful)

## Getting Started

### 1. Clone the Repository

```bash
git clone https://github.com/hanvee/mini-inventory-api.git
cd mini-inventory-api
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Set Up Environment File

```bash
cp .env.example .env
```
### 4. Set Up Environment File

```bash
php artisan key:generate

```
### 5. Run Migration
```bash
php artisan migrate:fresh --seed
```

### 7. Serve the App
```bash
php artisan serve
```
