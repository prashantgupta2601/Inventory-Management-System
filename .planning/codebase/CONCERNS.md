# Concerns

## Security
- **Hardcoded Credentials**: Plain text database configuration in `config.php`.
- **Session Security**: Basic session management without CSRF protection or password hashing (as noted in `README.md`).
- **Input Sanitization**: Potential risks in areas where user input is not consistently escaped before rendering.

## Technical Debt
- **Mixed Storage Paradigms**: The existence of both JSON and SQL implementations causes "split-brain" application state. Changes to inventory in one system do not reflect in the other.
- **Procedural Logic**: Heavy reliance on procedural scripts makes it difficult to implement shared logic or unit tests.
- **Code Duplication**: CRUD logic is duplicated across the root and subfolder versions.

## Reliability
- **Concurrent Access**: `data.json` is vulnerable to corruption if multiple users attempt to write simultaneously (lack of file locking).
- **Data Integrity**: Lack of schema validation for the JSON file can result in runtime errors if the structure is manually altered.

## Maintenance
- **Manual Infrastructure**: Automatic database table creation depends on specific connection privileges that may not exist in all environments.
- **Discovery**: Unintended visibility of system files (like `.git/` or `config.php`) if the server is not misconfigured.
