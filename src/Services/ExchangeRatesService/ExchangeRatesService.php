<?php

namespace Shota\TaskRefactorCode\Services\ExchangeRatesService;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Shota\TaskRefactorCode\Data\PriceData;
use Shota\TaskRefactorCode\Interfaces\CurrencyServiceInterface;

class ExchangeRatesService implements CurrencyServiceInterface
{
    protected Client $client;
    private array $config;
    protected Request $request;
    protected string $baseCurrency;
    protected array $rates = [];
    protected bool $fakeData = false;

    public function __construct()
    {
        $this->config = require 'config/currency.php';

        $this->setBaseCurrency($this->config['base_currency']);

        $this->client = new Client();
    }

    public function setBaseCurrency(string $currency): void
    {
        $this->baseCurrency = $currency;
    }

    public function getBaseCurrency(): string
    {
        return $this->baseCurrency;
    }

    public function enableFakeData(): void
    {
        $this->fakeData = true;
    }

    public function disableFakeData(): void
    {
        $this->fakeData = false;
    }

    public function getRealRates(): array
    {
        $response = $this->client->get($this->config['base_url'] . '/latest', [
            'query' => [
                'access_key' => $this->config['access_key'],
                'base' => $this->getBaseCurrency()
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getFakeRates(): array
    {
        return json_decode(file_get_contents('fake/exchange_rates_eur.json'), true);
    }

    public function getRates(): array
    {
        if ($this->rates) {
            return $this->rates;
        }

        $responseObject = $this->fakeData ? $this->getFakeRates() : $this->getRealRates();

        $this->rates = $responseObject['rates'];

        return $this->rates;
    }

    public function convertAmount(PriceData $price): PriceData
    {
        if ($price->currency === $this->getBaseCurrency()) {
            return $price;
        }

        $rates = $this->getRates();

        try {
            $rate = $rates[$price->currency];

            return new PriceData($price->amount / $rate, $this->getBaseCurrency());
        } catch (\Exception $e) {
            throw new \Exception('Can\'t find currency rate. Currency: ' . $price->currency);
        }
    }
}