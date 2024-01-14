# Product Manager

This Laravel web application offers product management and API services for backend operations.

## Getting Started

These instructions will guide you through setting up the project on your local machine.

### Prerequisites

Ensure you have the following installed:
- PHP >= 8.2
- Composer
- A relational database (e.g., MySQL)

### Installation

Follow these steps to get your development environment running:

1. **Clone the Repository**
   ```bash
   git clone git@github.com:NikaIlir/product-manager.git
   cd product-manager
    ```
   
2. **Install PHP Dependencies**
    ```bash
    composer install
    ```
3. **Environment Configuration**

   Create a copy of .env.example and name it .env, then configure your environment settings.
    ```bash
    cp .env.example .env
    ```
4. **Generate Application Key**
    ```bash
    php artisan key:generate
    ```
5. **Database Setup**

    Create a database for the application and update the .env file with the database credentials. Then run the migrations and seeders.
    ```bash
    php artisan migrate --seed
    ```
   
6. **Import Products**

   Execute this custom command to import products from *Fake Store API*.
    ```bash
    php artisan app:import-products
    ```
   
7. **Run the Application**
    ```bash
    php artisan serve
    ```
   Your application will be running at http://localhost:8000.

## API Documentation

The API documentation is available at `http://localhost:8000/api/documentation`. This documentation provides detailed information about the available endpoints, request formats, and expected responses.

## Running the Tests

To run the automated tests for this system:

```bash
php artisan test
```
