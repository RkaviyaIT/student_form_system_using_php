# Registration Form Web App

This is a web-based registration form built with PHP, MySQL, HTML, CSS, JavaScript, and enhanced UI features like Select2 for better user interaction. The application allows users to register through a form and displays submitted details with options to **search**, **print**, and **export to Excel**.

---

## 🚀 Features

- 📝 **Registration Form** (Left side)
  - Fields include name, email, phone, etc.
  - Select2-enabled dropdowns for better selection UI
  - Form validation using JavaScript

- 📄 **Display Section** (Right side)
  - Displays submitted data from the database
  - Real-time **search/filter** function
  - Option to **print** the data
  - Option to **export to Excel**

---

## 🛠️ Technologies Used

| Technology | Purpose                        |
|------------|--------------------------------|
| PHP        | Backend logic and form handling |
| MySQL      | Database to store submissions   |
| HTML/CSS   | Structure and styling           |
| JavaScript | Form validation and dynamic behavior |
| jQuery     | DOM manipulation, AJAX support  |
| Select2    | Enhanced dropdowns              |

---

## 📁 Project Structure
project/
│
├── index.html # Main UI page
├── style.css # Styling for the form and display area
├── script.js # JS for form validation and interactivity
├── submit.php # Handles form submission
├── fetch.php # Fetches records for display
├── export.php # Exports data to Excel
├── print.js # Print function for display section
├── db_config.php # Database connection config
└── README.md # Project overview


---

## ⚙️ Setup Instructions

1. Clone or download the project folder.
2. Create a MySQL database (e.g., `registration_db`) and import the provided SQL script.
3. Update `db_config.php` with your database credentials.
4. Run the app using a local server (e.g., XAMPP, WAMP, or MAMP).
5. Open `index.html` or `index.php` in your browser.

---

## 🙋‍♀️ Author

**Kaviya Rajaraman**  
*Passionate about web development and user-friendly design.*


