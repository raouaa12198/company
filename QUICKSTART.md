# QUICK START GUIDE

## 🚀 Get Started in 3 Steps

### Step 1: Copy to Your Web Server
Copy the `company_platform` folder to:
- **XAMPP:** `C:/xampp/htdocs/`
- **Laragon:** `C:/laragon/www/`
- **WAMP:** `C:/wamp/www/`

### Step 2: Run Setup
1. Start Apache & MySQL
2. Open browser: `http://localhost/company_platform/setup.php`
3. Wait for "Setup complete!" message

### Step 3: Visit the Website
**Main Website:** `http://localhost/company_platform/home.php`
**Employee Portal:** Click "Employee Portal" button or go to `http://localhost/company_platform/index.php`

## 🌐 Website Structure

### Public Website (home.php):
- ✅ Company presentation (Same-Info)
- ✅ Services section (Web Development, Design, E-Commerce, SEO, etc.)
- ✅ About section
- ✅ Contact section with phone & email
- ✅ Employee Portal button in navigation

### Employee Portal (index.php):
**Director Login:**
- Username: `director`
- Password: `director123`

**Employee Login:**
- Username: `john_doe`  
- Password: `employee123`

**Or Register New Account:**
- Choose role: Director or Employee
- Fill in details and register

**Forgot Password?**
- Click "Mot de Passe Oublié?" on login page
- Enter your email
- Get temporary password (displayed on screen - in production would be emailed)
- Login with temporary password
- Change password from dashboard sidebar

## ✅ What You Can Do

### Director Dashboard:
- ✅ View all employees
- ✅ Add new employees
- ✅ Update salaries
- ✅ Record absences (auto reduces salary by 10%)
- ✅ Delete employees
- ✅ Create & assign tasks
- ✅ View task completion

### Employee Dashboard:
- ✅ View your salary
- ✅ See assigned tasks
- ✅ Mark tasks complete
- ✅ Check absences

## 📁 Files Included:
- **home.php** - Main company website
- **index.php** - Login page (Employee Portal)
- **register.php** - Registration with role selection
- **forgot_password.php** - Password recovery (Mot de Passe Oublié)
- **change_password.php** - Change password after login
- **dashboard.php** - Main dashboard router
- **director_dashboard.php** - Director interface
- **employee_dashboard.php** - Employee interface
- **config.php** - Database config (DB: company_stage)
- **setup.php** - Database installer
- **logout.php** - Logout handler

## 📞 Contact Information (Customizable):
- **Phone:** +216 12 345 678, +216 98 765 432
- **Email:** contact@same-info.com, support@same-info.com
- **Address:** 123 Tech Street, Digital City, Tunis, Tunisia

## 💡 Navigation Flow:
1. Start at: `home.php` (Company website)
2. Click "Employee Portal" → Go to login
3. Login or Register with role selection
4. Access your dashboard based on role

## 🔧 Troubleshooting:
If login fails:
1. Check Apache & MySQL are running
2. Re-run setup.php
3. Clear browser cache
4. Verify database name: company_stage

Need help? Check README.md for detailed info!
