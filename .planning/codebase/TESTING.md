# Testing

## Automated Testing
- **Status**: None.
- **Frameworks**: No testing frameworks like PHPUnit or Pest are currently integrated into the repository.

## Manual Verification Process
1. **Environment Setup**: Start Apache and MySQL via XAMPP or equivalent.
2. **Database Migration**: Ensure `inventory_db` is created by visiting `config.php` (automatic creation logic).
3. **Application Access**:
   - SQL Version: Visit `http://localhost/inventory-system/index.html`.
   - JSON Version: Visit `http://localhost/inventory-system/Inventory-Management-System/index.php`.
4. **CRUD Flow**:
   - Add a product and verify it appears in the table.
   - Edit a product and verify changes persist.
5. **Insights**: Verify demand forecasting tooltips or charts load data correctly in the JSON version.

## Testing Gaps
- **AI Logic**: No verified unit tests for the forecasting algorithm in `api/fetch.php`.
- **Concurrency**: No tests for simultaneous writes to `data.json`.
