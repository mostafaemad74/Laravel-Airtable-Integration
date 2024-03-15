<?php

namespace Tests\Unit;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use App\Services\AirtableService;
use Illuminate\Validation\ValidationException;

class AirtableServiceTest extends TestCase
{
    protected $airtableService;
    protected $mockClient;

    public function setUp(): void
    {
        parent::setUp();
        // Mocking the Guzzle HTTP client
        $this->mockClient = $this->createMock(Client::class);
        $this->airtableService = new AirtableService($this->mockClient);
    }


    /** 
     * Test fetching Airtable data successfully.
     */
    public function test_can_fetch_airtable_data_successfully()
    {
        $sampleResponseData = [
            'records' => [
                ['id' => 'rec123', 'fields' => ['Business Name' => 'Test']],
            ]
        ];

        // Mock the response from the HTTP client
        $this->mockClient->expects($this->once())
            ->method('request')
            ->willReturn(new Response(200, [], json_encode($sampleResponseData)));

        $records = $this->airtableService->fetchAirtableData();

        $this->assertNotEmpty($records);
        $this->assertEquals('Test', $records[0]['fields']['Business Name']);
    }

    /** 
     * Test handling case when no records are found.
     */
    public function test_handle_no_records_found()
    {
        // Mock the response from the HTTP client with no records
        $this->mockClient->expects($this->once())
            ->method('request')
            ->willReturn(new Response(200, [], json_encode(['records' => []])));

        // Call the method to fetch Airtable data
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('No records found');
        $this->airtableService->fetchAirtableData();
    }

    /** 
     * Test updating business name successfully.
     */
    public function test_can_update_business_name_successfully()
    {
        $sampleResponseData = [
            'records' => [
                ['id' => 'rec123', 'fields' => ['Business Name' => 'Test']],
                ['id' => 'rec456', 'fields' => ['Business Name' => 'Airotax']],
            ]
        ];
        $this->mockClient->expects($this->once())
            ->method('request')
            ->willReturn(new Response(200, [], json_encode($sampleResponseData)));

        $this->airtableService->updateBusinessName('Test', 'Airotax');

        $this->assertTrue(true);
    }


    /** 
     * Test handling case when API request fails.
     */
    public function test_handle_api_request_failure()
    {
        // Mock the response from the HTTP client with API request failure
        $this->mockClient->expects($this->once())
            ->method('request')
            ->willThrowException(new \Exception('API request failed'));
            
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('API request failed');
        $this->airtableService->fetchAirtableData();
    }
}
