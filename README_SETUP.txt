PERSONNEL VERIFICATION – STAFF BIO-DATA APP (PHP)
Developed by Jay Jassen Tech

(Please retain this credit in all copies, distributions, and modifications.)

1. REQUIREMENTS

Windows PC

PHP 7+ for Windows (ensure pdo_sqlite and sqlite3 extensions are enabled)

Any modern web browser (Chrome, Edge, Firefox, Opera, etc.)

NOTE: This application uses a local SQLite database.
No MySQL, No XAMPP, No WAMP required.
Everything is fully self-contained.

2. DATABASE SETUP (SQLITE – AUTOMATIC)

No manual setup is required. On first run, the application automatically:

Creates a data folder (if missing).

Creates the database file: data/staff_biodata.sqlite.

Creates the staff table with all required bio-data fields.

If you get this error:

“could not find driver”
Enable these extensions inside your php.ini:

extension=pdo_sqlite

extension=sqlite3

3. RUNNING THE APPLICATION (BUILT-IN MINI SERVER)
1) Ensure PHP is Available

The app uses the PHP built-in server. Either:

Option A — Portable PHP inside the project

Place PHP inside a folder named php, like:

php\php.exe

Option B — Use Installed PHP

Edit start_app.bat and update:

set PHP_BIN=C:\path\to\php.exe

2) Start the Application

Double-click start_app.bat

The internal server runs at:
http://127.0.0.1:8080/

Your browser automatically opens index.php

3) Using the App

From the home screen:

New Registration – Enter staff bio-data, upload Passport + Fingerprint

View Registered Staff – Shows all records, includes:

Passport preview

Fingerprint download link

4. EXPORTING RECORDS

On Registered Staff page (list_staff.php), you can export:

✔ CSV Export
✔ Excel Export (.xls)

(HTML table rendered as Excel-readable file)

✔ PDF Export
PDF EXPORT SETUP (FPDF)

To enable PDF export:

Download FPDF from the official website.

Create a folder lib in the project root.

Copy fpdf.php into:

lib/fpdf.php


Click Export PDF again—your file
staff_records.pdf downloads automatically.

5. WINDOWS START APP DESKTOP ICON

To create a shortcut that launches the entire system:

Right-click Desktop → New → Shortcut

Enter path to the batch file:

C:\path\to\project\start_app.bat


Name it: Personnel Verification

Finish

(Optional) Right-click shortcut → Properties → Change Icon…
Assign a custom icon for professionalism.

6. NOTES

Passport and fingerprint images are stored in:

uploads/passports/

uploads/fingerprints/

SQLite stores file paths only, not the image binaries.

The UI uses Bootstrap 5, making it mobile-friendly and responsive.

The app is fully portable—just copy the entire folder to another PC.

CREDIT
This application was developed by Jay Jassen Tech.

Please maintain this attribution in all documentation, redistribution, and derivative work.