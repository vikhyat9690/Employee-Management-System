# Employee Management System

## Overview
The **Employee Management System** is a web-based application designed to manage employees effectively. This project includes role-based functionality, enabling administrators, managers, and employees to perform specific tasks. Built using **PHP**, **MySQL**, **HTML**, **CSS**, and **JavaScript**, it features a modular architecture and a central routing system for maintainability.

---

## Features

### **Authentication**
- Login and signup functionality with secure password hashing.
- Role-based access control (Admin, Manager, Employee).
- Logout functionality.

### **Dashboard**
- Role-specific dashboards:
  - **Admin**: Manage all users.
  - **Manager**: Manage team members and view reports.
  - **Employee**: View personal details and tasks.

### **Profile Management**
- Update personal details (name, age, address, etc.).
- Add, edit, or remove qualifications and experiences.
- Upload and update profile pictures.
- AJAX-based updates for seamless interaction.

### **User Management** (Admin/Manager)
- View a list of all users.
- Add, edit, or delete users.
- Manage specific user details.

### **Central Routing System**
- Centralized routing file for mapping URLs to handlers.
- Clean and user-friendly URLs.

### **ScreenShots**
- [Authentication-[SignUP]](./screenshots/signup.png)
- [Authentication-[Login]](./screenshots/login.png)
- [Dashboard](./screenshots/dashboard.png)
- [Profile](./screenshots/profile.png)
- [Manage Users Panel](./screenshots/manage-users.png)
- [Manage User Panel](./screenshots/manage-user.png)

---

## Folder Structure
```
employee_management_system/
|
├── assets/                   # Static files (CSS, JS, images)
│   └── style/                # Stylesheets
│
├── modules/                  # Feature-based modules
│   ├── auth/                 # Authentication (login, signup, logout)
│   ├── profile/              # User profile management
│   ├── dashboard/            # Role-specific dashboards
│   └── admin/                # Admin-specific functionality
│       ├── manage_users.php  # Manage users
│       └── manage_user.php   # Manage individual user
│
├── scripts/                  # Utility scripts (e.g., AJAX handlers)
├── includes/                 # Shared components (header, footer, functions)
├── config/                   # Configuration files
│   ├── db.php                # Database connection
│   └── routes.php            # Central routing definitions
│
├── public/                   # Public-facing directory
│   └── index.php             # Entry point for routing
│
└── README.md                 # Project documentation
```

---

## Installation

### **Requirements**
- PHP 7.4 or higher
- MySQL 5.7 or higher
- A web server (e.g., Apache, Nginx)

### **Setup**
1. Clone the repository:
   ```bash
   git clone https://github.com/your-repo/emp_management_system.git
   ```

2. Navigate to the project directory:
   ```bash
   cd emp_management_system
   ```

3. Import the database:
   - Create a database in MySQL (e.g., `employee_management_system`).
   - Import the SQL schema located in `sql/schema.sql`:
     ```bash
     mysql -u username -p employee_management_system < sql/schema.sql
     ```

4. Configure the database connection:
   - Update `config/db.php` with your MySQL credentials.

5. Start the development server:
   ```bash
   php -S localhost:8000 -t public/
   ```

6. Open the application in your browser:
   ```
   http://localhost:8000
   ```

---

## Usage

### **Default Roles**
- **Admin**: Full access to user management and reports.
- **Manager**: Access to team management and reports.
- **Employee**: Limited to personal details and tasks.

### **Testing Users**
You can create users via the signup page or directly insert test data into the `users` table.

---

## Security Features
- Password hashing using `password_hash`.
- Input sanitization to prevent SQL injection and XSS.
- Role-based access control to protect restricted pages.
- Secure file uploads with MIME type validation.

---

## Roadmap
Potential enhancements:
- Implement advanced reporting features.
- Add notification and messaging functionality.
- Integrate RESTful APIs for external access.
- Enhance UI with modern frameworks like React or Vue.

---

## License
This project is open-source and available under the [MIT License](LICENSE).

---

## Contributors
- **Your Name** - Developer
- **Team Members** - Contributors

---

## Acknowledgments
Special thanks to resources like [PHP.net](https://www.php.net/) and [W3Schools](https://www.w3schools.com/) for their comprehensive documentation.

