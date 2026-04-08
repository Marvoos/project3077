# COMP3077 - Full Stack Web Development Project

## Simple Library System (SLS)

__Made by:__ Kayden Ions

## Business Case

This project is a book catalogue system built for a small library or school library environment. The catalogue is designed to help users search for available books, view details, and borrow items for a set period. Administrative staff can also manage the book records, including adding, editing, and deleting books.

The business case is focused on a library catalogue that supports:

- book search and filtering by availability and arrival date
- secure registration and login
- borrowing management with due dates
- administrative inventory control

## Installation

To install this app on another website or local development machine, follow these steps:

1. Install a web server stack that supports PHP and MySQL, such as XAMPP, WAMP, or MAMP.
2. Copy the project files into the web server document root. For XAMPP, this is usually `C:\xampp\htdocs\project3077`.
3. Create the database:
   - Open phpMyAdmin or MySQL CLI.
   - Create a new database named `sls_data`.
   - Import `sql_scripts/site_database.sql` to create the tables.
   - Import `sql_scripts/insert_books.sql` to add sample book data.
4. Configure the database connection:
   - Open `config.php`.
   - Update `$host`, `$dbName`, `$dbUser`, and `$dbPass` for your environment.
5. If email verification is needed, configure a mail sender or update the registration workflow to use your SMTP setup.
6. Open the site in your browser at `http://localhost/project3077/home/index.php`.
7. Register a new user and verify the workflow from the sign-in, browse, and borrow pages.

## Notes

- The app uses PHP sessions for login state.
- The status page is available at `status/index.php` to check database and table availability.
- Some pages currently use placeholder or demo content for future enhancements.
