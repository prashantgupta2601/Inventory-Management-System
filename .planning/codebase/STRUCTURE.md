# Project Structure

## Directory Layout

```text
/inventory-system (Root)
├── .planning/               # GSD planning and codebase map
├── Inventory-Management-System/ # JSON-based Version
│   ├── api/                 # AI Insights and dynamic data
│   ├── css/                 # Stylesheets
│   ├── add_product.php      # CREATE product
│   ├── edit_product.php     # UPDATE product
│   ├── dashboard.php        # Main dashboard
│   ├── data.json            # JSON Storage
│   └── index.php            # Entry / Login
├── config.php               # SQL Configuration
├── index.html               # Entry for SQL Version
├── inventory.php            # READ inventory (SQL)
└── update.php               # CREATE product (SQL)
```

## Key Files

### Root (SQL Version)
- **config.php**: Database connection setup and schema initialization.
- **index.html**: Static landing page.
- **inventory.php**: Displays SQL inventory data in a table.
- **update.php**: Handles POST requests to insert new items into MySQL.

### Subfolder (JSON Version)
- **data.json**: The primary data store for the legacy/demo variant.
- **api/fetch.php**: Processes JSON data to calculate forecasting insights.
- **dashboard.php**: Provides a feature-rich view of the JSON inventory.
