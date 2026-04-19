# Architecture

## Pattern
The codebase follows a **Monolithic Procedural** pattern. Pages are individual PHP files that handle both logic and presentation.

## Core Components
- **Dashboard**: The central hub (`dashboard.php`) for reviewing inventory state.
- **Product Management**: CRUD operations handled by `add_product.php`, `edit_product.php`, and `update.php`.
- **Authentication**: Basic session-based login/logout system (`login.php`, `logout.php`).
- **AI Integration**: A dedicated API endpoint (`api/fetch.php`) implements demand forecasting and sales trend analysis using simple moving averages.

## Data Flow
1. **Request**: Browser requests a PHP page.
2. **Logic**: PHP page includes `config.php` or reads `data.json`.
3. **Execution**: Logic (fetching, inserting, or calculating) is performed inline.
4. **Response**: HTML is rendered and returned to the client.

## Design Decisions
- **Hybrid Storage**: The project contains two storage backends, suggesting a transition from JSON-based lightweight storage to a SQL-based structured database.
- **Minimal Dependencies**: The application relies primarily on native PHP functionality and Bootstrap (CDN) to keep deployment simple.
