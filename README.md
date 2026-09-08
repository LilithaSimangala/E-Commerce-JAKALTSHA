# JAKALTSHA

## E-Commerce Music Platform

JAKALTSHA is a South African-focused e-commerce and music platform designed to bring **music, artists, merchandise and listeners together in one digital space**.

The platform allows users to discover local artists and their music, browse merchandise, add products to a shopping cart, register and log in, and complete an online ordering process.

The project combines a **Vue.js frontend**, a **PHP backend API**, and a **MySQL database**.

---

## Project Overview

JAKALTSHA was developed as an e-commerce platform with a strong focus on supporting South African artists and creating a central place where users can interact with music and artist-related products.

The platform brings together:

* Music discovery
* Artist profiles
* Artist-related merchandise
* Product browsing
* Shopping cart functionality
* Customer registration and authentication
* Checkout and payment flow
* Order confirmation
* Backend API services
* MySQL database management

---

## Main Features

### 🎵 Music

Users can browse music available on the platform and listen to locally hosted music files.

Music is organised according to artists, making it easier for users to discover different artists and their work.

### 🎤 Artists

The platform includes artist profiles containing artist-related information and associated music.

Artists currently represented in the project include:

* JTT
* Iconikkid
* RipperRSA
* SobersZA
* LIBHO

### 🛍️ Shop

Users can browse products available through the JAKALTSHA store.

Products include artist merchandise and other music-related items.

### 🛒 Shopping Cart

Users can:

* Add products to their cart
* View products in their cart
* Adjust quantities
* Review their order before checkout

### 💳 Checkout

The platform provides a checkout workflow where users can review their purchase and proceed through the payment stage.

### 📦 Orders

Orders are processed through the backend API and users receive an order confirmation after completing the ordering process.

### 🔐 Authentication

The platform includes customer registration and login functionality.

---

## Technologies Used

### Frontend

* Vue.js
* Vue Router
* Pinia
* Vite
* JavaScript
* HTML5
* CSS3

### Backend

* PHP
* PHP REST-style API
* MySQL
* PDO

### Development Tools

* XAMPP
* MySQL
* MySQL Workbench
* Git
* GitHub
* Visual Studio Code

---

## Project Structure

```text
JAKALTSHA/
│
├── backend/
│   ├── config/
│   │   └── database.php
│   │
│   ├── controllers/
│   │   ├── ArtistController.php
│   │   ├── AuthController.php
│   │   ├── MusicController.php
│   │   ├── OrderController.php
│   │   └── ProductController.php
│   │
│   ├── routes/
│   │   ├── artists.php
│   │   ├── auth.php
│   │   ├── music.php
│   │   ├── orders.php
│   │   └── products.php
│   │
│   ├── index.php
│   └── test_connection.php
│
├── frontend/
│   ├── public/
│   │   ├── images/
│   │   └── music/
│   │
│   └── src/
│       ├── components/
│       │   ├── Footer.vue
│       │   └── Navbar.vue
│       │
│       ├── services/
│       │   └── api.js
│       │
│       ├── stores/
│       │   └── counter.js
│       │
│       ├── views/
│       │   ├── ArtistDetailsPage.vue
│       │   ├── ArtistsPage.vue
│       │   ├── CartPage.vue
│       │   ├── CheckoutPage.vue
│       │   ├── HomePage.vue
│       │   ├── LoginPage.vue
│       │   ├── MusicPage.vue
│       │   ├── OrderConfirmationPage.vue
│       │   ├── PaymentPage.vue
│       │   ├── ProductDetailsPage.vue
│       │   ├── RegisterPage.vue
│       │   └── ShopPage.vue
│       │
│       ├── App.vue
│       ├── main.js
│       └── router/
│           └── index.js
│
├── JAKALTSHA.sql
├── .gitignore
└── README.md
```

---

## Database

The project uses **MySQL** as its relational database.

The complete database setup is provided in:

```text
JAKALTSHA.sql
```

The database handles information relating to users, artists, products, music and orders.

The backend connects to MySQL through PDO using the database configuration located at:

```text
backend/config/database.php
```

---

## Backend API

The backend is structured around controllers and routes.

### Available route areas

| Route          | Purpose                                  |
| -------------- | ---------------------------------------- |
| `auth.php`     | Authentication and user-related requests |
| `artists.php`  | Artist-related requests                  |
| `music.php`    | Music-related requests                   |
| `products.php` | Product-related requests                 |
| `orders.php`   | Order-related requests                   |

Controllers are located in:

```text
backend/controllers/
```

and database configuration is located in:

```text
backend/config/database.php
```

---

## Frontend Pages

The Vue frontend contains dedicated pages for the major areas of the platform.

### Main pages

* Home
* Artists
* Artist Details
* Music
* Shop
* Product Details
* Cart
* Checkout
* Payment
* Order Confirmation
* Login
* Register

Navigation between pages is handled using **Vue Router**.

---

## Installation

### Requirements

Before running JAKALTSHA, install:

* XAMPP
* PHP
* MySQL
* Node.js
* npm
* Git

---

## 1. Clone the Repository

```bash
git clone https://github.com/LilithaSimangala/E-Commerce-JAKALTSHA.git
```

Enter the project:

```bash
cd E-Commerce-JAKALTSHA
```

---

## 2. Set Up the Database

Start **Apache** and **MySQL** through XAMPP.

Open MySQL Workbench or phpMyAdmin and import:

```text
JAKALTSHA.sql
```

This creates the database and required tables.

---

## 3. Configure the Backend

Check the database configuration in:

```text
backend/config/database.php
```

Update the database connection details if your local MySQL configuration differs.

---

## 4. Install Frontend Dependencies

Navigate to the frontend:

```bash
cd frontend
```

Install dependencies:

```bash
npm install
```

---

## 5. Run the Frontend

From the `frontend` directory:

```bash
npm run dev
```

Vite will provide the local development address in the terminal.

---

## 6. Run the Backend

The PHP backend is intended to run through the XAMPP Apache server.

Place the project inside:

```text
xampp/htdocs/
```

The backend can then be accessed through the local Apache server according to the configured API routes.

---

## Testing

The backend includes a database connection test:

```text
backend/test_connection.php
```

This can be used to verify that the PHP backend is successfully connecting to MySQL.

The frontend can also be tested by navigating through the available pages and testing:

* Registration
* Login
* Artist browsing
* Music browsing
* Product browsing
* Cart functionality
* Checkout
* Payment flow
* Order confirmation

---

## Git & GitHub

The project is version-controlled using Git and hosted on GitHub.

Repository:

**E-Commerce-JAKALTSHA**

The `main` branch contains the current project.

The project uses a `.gitignore` file to prevent unnecessary or sensitive files such as dependencies and environment configuration files from being committed.

---

## Future Improvements

Possible future development includes:

* Artist accounts and dashboards
* Artist royalty tracking
* Online payment gateway integration
* Music streaming analytics
* Artist merchandise management
* Radio station partnerships
* Event and tour promotion
* Vinyl and physical music sales
* Improved user profiles
* Advanced search and filtering
* Admin dashboard
* Production deployment
* Cloud-based media storage

---

## Project Purpose

JAKALTSHA aims to provide more than a conventional online store.

The long-term concept is to create a platform where **South African artists can promote their music, merchandise, shows and creative work while listeners have a central place to discover and support them.**

The platform therefore combines elements of:

**Music + E-Commerce + Artist Promotion + Community**

---

## Author

**Lilitha Simangala**

South Africa

---

## Repository

GitHub:

https://github.com/LilithaSimangala/E-Commerce-JAKALTSHA
