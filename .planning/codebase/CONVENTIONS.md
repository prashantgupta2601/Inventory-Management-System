# Conventions

## PHP Patterns
- **Procedural Logic**: Most pages follow a top-down execution style without formal class structures.
- **Global Variables**: Use of session and POST superglobals (`$_SESSION`, `$_POST`).
- **Mixed Content**: PHP logic is frequently interleaved with HTML/CSS within the same file.

## Data Processing
- **SQL Security**: Use of prepared statements (`$conn->prepare()`, `bind_param()`) in the root directory implementation.
- **JSON Serialization**: Direct use of `json_decode` for state management in the subfolder version.

## Naming Conventions
- **Variables**: Predominantly snake_case (`$product_id`, `$sales_history`).
- **Functions**: Mixture of camelCase (`calculateAIInsights`) and snake_case.
- **Filenames**: kebab-case or snake_case (e.g., `add_product.php`, `data.json`).

## Styling
- **CSS**: External CSS files (`css/`) combined with inline style tags and Bootstrap classes.
- **Dashboard**: Table-based layout for inventory display.
