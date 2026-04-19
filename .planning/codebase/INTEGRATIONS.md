# Integrations

## Database (MySQL)
The system connects to a MySQL database named `inventory_db` via the `mysqli` driver.
- **Config**: `config.php` handles connection and automatic table creation if missing.
- **Status**: Active in root directory files (`inventory.php`, `update.php`).

## Data Storage (JSON)
The system uses a flat JSON file for inventory state in the legacy/demo version.
- **Location**: `Inventory-Management-System/data.json`
- **Access**: Read/written via `file_get_contents()` and `json_decode()`/`json_encode()`.

## API Endpoints
- **api/fetch.php**: Provides internal logic for AI-based insights (demand forecasting) by processing sales history from `data.json`.
