# Company Platform - Same-Info Web Development

A complete PHP-based employee management system with a professional company website.

## Project Structure

### 1. Public Website (home.php)
Professional company website featuring:
- Company presentation and mission
- Services showcase (Web Development, Design, E-Commerce, SEO, etc.)
- About section with company values
- Contact section with phone, email, and contact form
- Direct link to Employee Portal

### 2. Employee Management Portal
Role-based employee management system with:
- Secure login and registration
- Director and Employee dashboards
- Task management
- Salary tracking
- Absence recording

## Features

### Director Features:
- View all employees with their details
- Add new employees manually
- Update employee salaries
- Record employee absences (reduces salary by 10%)
- Delete employees (tasks remain in history)
- Create and assign tasks to employees
- View all tasks and their completion status
- Dashboard with statistics

### Employee Features:
- View personal salary (affected by absences)
- View assigned tasks
- Mark tasks as completed
- View absence history
- Personal dashboard with statistics

## Installation Steps

### 1. Prerequisites
- XAMPP/WAMP/Laragon with PHP and MySQL
- Web browser

### 2. Setup Instructions

1. **Copy files to web server:**
   - Copy the entire `company_platform` folder to your web server directory
   - For XAMPP: `C:/xampp/htdocs/company_platform`
   - For Laragon: `C:/laragon/www/company_platform`

2. **Start your web server:**
   - Start Apache and MySQL from your control panel

3. **Run the setup script:**
   - Open your browser and navigate to: `http://localhost/company_platform/setup.php`
   - This will create the database and tables automatically
   - Sample accounts will be created

4. **Login:**
   - Navigate to: `http://localhost/company_platform/`
   - Use one of the sample accounts:

   **Director Account:**
   - Username: `director`
   - Password: `director123`

   **Employee Account:**
   - Username: `john_doe`
   - Password: `employee123`

## Database Structure

The system uses MySQL with database name **company_stage** and three main tables:
- `users` - Stores director and employee information
- `tasks` - Stores all tasks assigned to employees
- `absences` - Tracks employee absences

## File Structure

```
company_platform/
├── home.php                   # Main company website
├── index.php                  # Login page (Employee Portal)
├── register.php              # Registration with role selection
├── config.php                 # Database configuration (DB: company_stage)
├── dashboard.php             # Main dashboard (routes by role)
├── director_dashboard.php    # Director's dashboard
├── employee_dashboard.php    # Employee's dashboard
├── logout.php                # Logout script
├── setup.php                 # Database setup script
├── README.md                 # Full documentation
└── QUICKSTART.md             # Quick setup guide
```

## Usage

### Visiting the Company Website:
1. Navigate to `http://localhost/company_platform/home.php`
2. Browse company information, services, and contact details
3. Click "Employee Portal" to access the management system

### As Director:
1. Login with director credentials
2. View/manage employees in the "Employees" tab
3. Create tasks in the "Tasks" tab
4. Click on employee actions to:
   - Update salary ($ icon)
   - Add absence (calendar icon)
   - Delete employee (trash icon)

### As Employee:
1. Login with employee credentials or register a new account
2. View your salary on the Overview tab
3. Check and complete tasks in "My Tasks" tab
4. Review absences in "Absences" tab

## Notes

- **Database name:** company_stage
- **Contact information:** Edit home.php to customize phone, email, and address
- Each absence reduces employee salary by 10%
- Deleted employees' tasks remain in the system
- New employee registrations with role selection (Director or Employee)
- Tasks marked as done by employees update immediately in director's view
- All passwords are securely hashed using PHP's password_hash()

## Security Features

- Password hashing
- SQL injection prevention with prepared statements
- Session-based authentication
- Role-based access control

## Support

For issues or questions, check your:
- PHP error logs
- MySQL error logs
- Browser console for any JavaScript errors

## Default Credentials

After running setup.php:

**Director:**
- Username: director
- Password: director123

**Employee:**
- Username: john_doe
- Password: employee123
