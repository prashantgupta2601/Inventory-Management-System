# Requirements - Milestone 1: Hardening & Data Migration

## 🎯 Primary Goal
Unify the system to use MySQL exclusively as the source of truth and implement modern security best practices.

## 🏗️ Technical Requirements
### R-1: MySQL Source of Truth
- [ ] Migrate all data from `data.json` to the `inventory` table in `inventory_db`.
- [ ] Update all CRUD operations (`add_product.php`, `edit_product.php`, `update.php`) to perform SQL queries instead of JSON writes.
- [ ] Update Dashboard and API (`dashboard.php`, `api/fetch.php`) to read from the database.
- [ ] Implement a one-time "Import from JSON" logic to ensure no data loss.

### R-2: Security Hardening
- [ ] **Authentication:** Implement `password_hash()` and `password_verify()` for user login.
- [ ] **CSRF Protection:** Add CSRF tokens to all forms (`index.php`, `add_product.php`, `edit_product.php`).
- [ ] **Input Sanitization:** Use prepared statements for ALL database interactions to prevent SQL Injection.
- [ ] **Environment Security:** Move database credentials from `config.php` to a `.env` file (using a lightweight PHP env loader).

### R-3: UI/UX Continuity
- [ ] Ensure the Bootstrap dashboard remains fully functional after the data source switch.
- [ ] Maintain Chart.js visualization compatibility with the new SQL schema.

## ✅ Success Criteria
- [ ] Application functions perfectly without `data.json`.
- [ ] SQL Injection is mitigated via prepared statements.
- [ ] Passwords are stored as hashes in the database.
- [ ] Dashboard displays accurate live data from MySQL.
