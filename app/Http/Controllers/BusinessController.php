<?php

namespace App\Http\Controllers;

use App\Services\AirtableService;

class BusinessController extends Controller
{

    protected $airtableService;

    /**
     * Constructor for the class.
     *
     * @param AirtableService $airtableService The Airtable service
     */
    public function __construct(AirtableService $airtableService)
    {
        $this->airtableService = $airtableService;
    }

    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function businessData()
    {
        // Fetch records
        $businessData = $this->airtableService->fetchAirtableData();

        return response()->json($businessData);
    }

    /**
     * Updates the business name from old name to new name.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateBusinessName()
    {
        // Update the Business Name from "Test" to "Airotax"
        $this->airtableService->updateBusinessName('Test', 'Airotax');

        return response()->json(['message' => 'Business name updated successfully.']);
    }
}
