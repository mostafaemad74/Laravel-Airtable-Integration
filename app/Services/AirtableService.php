<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Validation\ValidationException;

class AirtableService
{
    protected $client;

    /**
     * Constructor for initializing the Client with base URI and headers for Airtable API.
     */
    public function __construct()
    {
        try {
            $this->client = new Client([
                'base_uri' => config('services.airtable.base_url'),
                'headers' => [
                    'Authorization' => 'Bearer ' . config('services.airtable.api_key'),
                    'Content-Type' => 'application/json',
                ],
            ]);
        } catch (RequestException $e) {
            throw ValidationException::withMessages(['error' => $e->getMessage()]);
        }
    }

    /**
     * Fetches data from Airtable and returns records.
     *
     * @return array Records from Airtable
     * @throws \Illuminate\Validation\ValidationException
     */
    public function fetchAirtableData()
    {
        try {
            // Fetch records
            $response = $this->client->request('GET', config('services.airtable.table_name'));

            $data = json_decode($response->getBody()->getContents(), true);
            if (!isset($data['records'])) {
                throw new \Exception('No records found');
            }
            return $data['records'];
        } catch (\Exception $e) {
            throw ValidationException::withMessages(['error' => $e->getMessage()]);
        }
    }


    /**
     * Updates the business name from old name to new name.
     *
     * @param mixed $oldName 
     * @param mixed $newName 
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateBusinessName($oldName, $newName)
    {
        // Fetch records
        $records = $this->fetchAirtableData();
        $found = false;

        foreach ($records as $record) {
            if (isset($record['fields']['Business Name']) && $record['fields']['Business Name'] === $oldName) {
                // Update the Business Name to "Airotax"
                $this->client->patch(config('services.airtable.table_name') . '/' . $record['id'], [
                    'json' => ['fields' => ['Business Name' => $newName]],
                ]);
                $found = true;
            }
        }

        if (!$found) {
            throw ValidationException::withMessages(['error' => 'Business name not found']);
        }
    }
}
