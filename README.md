# Laravel-Airtable Integration

## Task Description

### Project Title: Laravel-Airtable Integration

### Task Objective:
Demonstrate proficiency in Laravel and Airtable integration by creating a function that retrieves data from the "Business Database" table and updates the name of a business from "Test" to "Airotax".

## Running the Application

1. **Clone the repository:**

    ```
    git clone <repository_url>
    ```

2. **Install dependencies:**

    ```
    composer install
    ```

3. **Configure `.env` file:**

    Ensure that the `.env` file is properly configured with necessary environment variables such as database connection settings and Airtable API credentials.

# AirtableService Class

## Description 

The `AirtableService` class is responsible for interacting with the Airtable API to fetch and update records from the "Business Database" table. It provides methods for fetching data from Airtable and updating the business name.

## Class Structure

The `AirtableService` class is structured as follows:

- **Constructor**: Initializes the Guzzle HTTP client with base URI and headers for the Airtable API.

- **fetchAirtableData()**: Fetches data from Airtable and returns records from the "Business Database" table.

- **updateBusinessName($oldName, $newName)**: Updates the business name from the old name to the new name.

## Usage

To use the `AirtableService` class in your Laravel application:

1. **Constructor Setup**:

    Ensure that the `base_uri`, `api_key`, and `table_name` configuration values are correctly set in the `config/services.php` file.

2. **Fetch Data**:

    Call the `fetchAirtableData()` method to retrieve records from the "Business Database" table in Airtable.

3. **Update Business Name**:

    Call the `updateBusinessName($oldName, $newName)` method to update the business name from the old name to the new name.

## Error Handling

- The class throws a `ValidationException` if there are any errors during API requests or if no records are found.

## Dependencies

- This class relies on the Guzzle HTTP client for making requests to the Airtable API.

## Sample Code

```php
use App\Services\AirtableService;

// Instantiate AirtableService
$airtableService = new AirtableService();

// Fetch Airtable data
$records = $airtableService->fetchAirtableData();

// Update business name
$airtableService->updateBusinessName('Old Business Name', 'New Business Name');
