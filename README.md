# RBAC-System_Rest_API_Vue3
A Role-Based Access Control (RBAC) System using Laravel for the backend and Vue 3 for the front end.
Backend (Laravel)

1. User Authentication  
   Implemented a full-featured authentication system using Laravel's built-in authentication features.
   Used Laravel Sanctum to implement token-based API authentication.
   Ensured that users can register, log in, and log out securely.

2. Role Management
    Created three distinct roles: `Admin`, `Manager`, and `User`.
    Admin users have full control over user management (creating, updating, deleting users, and assigning roles).
    Managers have limited control (e.g., managing users but no access to certain admin features).
    Regular users only have access to their own information.

3. Permissions System
    Implemented a system to assign specific permissions to roles when created role.
    For example, `Admin` can perform all actions, `Manager` can create/edit users but cannot delete, and `User` can only view their own profile.
    Ensured that permissions can be dynamically assigned and revoked by the Admin.

4. RESTful API
    Developed a RESTful API to manage users, roles, and permissions.
    API support the following operations:
    Create, update, delete, and fetch users.
     Assign roles and permissions to users.
     CRUD operations for roles and permissions.
     Protected the API routes using middleware to ensure that only authorized users can access certain routes.

5. Database Design
    Used MySQL for the database.
    Implemented proper relationships between users, roles, and permissions.
    Used migrations to set up database tables.
    Seed the database with sample data for testing (e.g., create default roles and permissions).

6. Validation & Error Handling
    Implemented server-side validation for all input data (e.g., user registration, role assignments).
    Provided meaningful error messages for both API and UI consumption.
    Handle edge cases gracefully (e.g., trying to delete a user currently assigned as an admin).

Frontend (Vue)

1. Admin Dashboard
    Created a user-friendly Admin Dashboard where the admin can:
     View all users and their assigned roles.
     Create, update, and delete users.
     Assign and revoke roles/permissions to/from users.

2. User Dashboard
    Created a basic User Dashboard that displays the user's profile information.
    Implemented role-based rendering, meaning regular users should only see limited information compared to admins.
    Ensured that the UI dynamically adapts based on the user’s role and permissions.

3. Form Validation
    Implemented client-side form validation.
    Ensured consistency between client-side and server-side validation rules.

# Setup Precess
1. Download or Clone the Repository
Option 1: Download as a ZIP file
  Click the "Code" button on the GitHub repository page.
  Select "Download ZIP."
  Extract the ZIP file to your desired directory.

Option 2: Clone the Repository
  Open your terminal or command prompt.
  Run the following command:
    git clone https://github.com/your-username/your-repository.git
  Navigate to the project directory:
    cd your-repository
2. Install Dependencies
Install Composer dependencies:
Run the following command to install the PHP dependencies:
  composer install
If you don't have Composer installed, download and install it from getcomposer.org.
Install NPM dependencies:

Run the following command to install the JavaScript dependencies:

npm install
If you don't have Node.js and NPM installed, download and install them from nodejs.org.
3. Set Up Environment Variables
Create a .env file:

Copy the .env.example file to create a new .env file:

  cp .env.example .env
Open the .env file in a text editor and configure the necessary environment variables (e.g., database connection, APP_NAME, APP_URL).
Generate an application key:

Run the following command to generate a unique application key:

  php artisan key:generate
4. Set Up the Database
Create a new database:

Create a new database in your MySQL or other database management system.
Update the DB_DATABASE, DB_USERNAME, and DB_PASSWORD variables in your .env file with the correct database credentials.
Run migrations:

Run the following command to create the tables in your database:

  php artisan migrate
Seed the database:
  php artisan db:seed

***database also provided with code***(If Needed You can use it)
5. Compile Assets
Compile the Vue.js assets:
Run the following command to compile the front-end assets:

npm run dev

6. Start the Development Server
Run the Laravel server:

Start the Laravel development server by running:

php artisan serve
Open your browser and navigate to the URL provided (usually http://127.0.0.1:8000).

7. Troubleshooting
Clear caches:

If you encounter any issues, try clearing Laravel caches:

php artisan config:cache
php artisan route:cache
php artisan view:cache

Check for errors:
Review your terminal and browser console for any errors during the setup process.
