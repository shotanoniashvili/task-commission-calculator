<?php

namespace Shota\TaskRefactorCode\Services\BinListService;

use GuzzleHttp\Client;
use Shota\TaskRefactorCode\Data\BinData;
use Shota\TaskRefactorCode\Data\CountryData;
use Shota\TaskRefactorCode\Interfaces\BinServiceInterface;

class BinListService implements BinServiceInterface
{
    protected Client $client;
    private array $config;

    public function __construct()
    {
        $this->config = require 'config/bin.php';

        $this->client = new Client();
    }

    public function getBinData(string $bin): BinData
    {
        $response = $this->client->get($this->config['base_url'] . '/' . $bin);

        $responseObject = json_decode($response->getBody()->getContents(), true);

        try {
            return new BinData(
                scheme: $responseObject['scheme'],
                bankName: $responseObject['bank']['name'],
                country: new CountryData(
                    name: $responseObject['country']['name'],
                    code: $responseObject['country']['alpha2'],
                    currency: $responseObject['country']['currency']
                ));
        } catch (\Exception $e) {
            throw new \Exception('Invalid response: ' . $response->getBody()->getContents());
        }
    }
}