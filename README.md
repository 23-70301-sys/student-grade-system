# student-grade-system

# Student Grade Management System

A simple PHP-based web application for managing student grades, built as a
group laboratory project simulating a real-world Git/GitHub collaboration
workflow.

## Team Roles

| Member    | Responsibility            |
|-----------|----------------------------|
| Student A | Project Manager            |
| Student B | Authentication Module      |
| Student C | Grade Management Module    |

## Project Structure

```
student-grade-system/
│
├── index.php        # Entry point / redirect handler
├── login.php         # Login page (Authentication Module)
├── dashboard.php      # User dashboard after login
├── grades.php         # Grade management page
│
├── css/
│   └── cssstyle.css   # Global styles
│
├── js/
│   └── jsapp.js        # Client-side scripts (validation, UI interactions)
│
└── README.md
```

## Features

### Authentication Module (login.php)
- Client-side and server-side form validation
- Show/Hide password toggle
- Improved, responsive login layout
- "Remember me" option
- Inline error messages for invalid input

### Grade Management Module (grades.php)
- Student records table
- Grade computation
- Search and sort functionality
- Color-coded grade status

## Getting Started

1. Clone the repository:
   ```bash
   git clone https://github.com/<org-or-owner>/student-grade-system.git
   ```
2. Serve the project with a local PHP server:
   ```bash
   php -S localhost:8000
   ```
3. Open `http://localhost:8000` in your browser.

## Demo Credentials

```
Email:    student@bsu.edu.ph
Password: password123
```

## Git Workflow

This project follows a feature-branch workflow:

- Work is done on feature branches (`feature/authentication-module`,
  `feature/grade-management-module`), never directly on `main`.
- Changes are submitted via Pull Requests and reviewed by the Project Manager
  before merging.
- `git rebase` is used to keep feature branches up to date with `main`.
- `git stash` is used to temporarily shelve unfinished work when urgent fixes
  are needed.

## License

This project is for educational purposes as part of a BSIT coursework
laboratory activity.