# Client SDK for Baltyre B2B API

## Introduction

This package offers services to loading data from Baltyre B2B API. It maps raw JSON data to pretty DTO's (data transfer objects), that is nice e.g. for hinting properties in your IDE.


## Installation

The recommended way to install is via Composer:

```
composer require baltyre/b2b-client
```

It requires PHP version 8.0 and supports PHP up to 8.2.

## Configuration

You can create and configure services manualy:

```php
use Baltyre\B2BClient\ApiConnector;
use Baltyre\B2BClient\CatalogLoader;
use Baltyre\B2BClient\PriceListLoader;
use Baltyre\B2BClient\StockLoader;

$apiKey = "<your-secrect-api-key>";
$baseUrl = "https://b2b.baltyre.com/api";
// for HU customers: $baseUrl = "https://b2b.baltyre.hu/api";
// for AT customers: $baseUrl = "https://b2b.osterreifen.com/api";

$connector = new ApiConnector($baseUrl, $apiKey);
$catalog = new CatalogLoader($connector);
$pricelist = new PriceListLoader($connector);
$stock = new StockLoader($connector);
```

## Usage

### Catalog
To get all products just call:

```php
$collection = $catalog->load();
```

This returns a `ProductCollection` that constains `ProductData` objects with next properties:

```php
class ProductData
{
    public string $code;                        // product code
    public string $name;                        // product name
    public ?string $ean;                        // EAN
    public ?string $manufacturer_code;          // code from manufacturer
    public ?Manufacturer $manufacturer; 
    public ?Pattern $pattern;
    public ?ParameterCollection $parameters;    // collection that containst `Parameter` objects
    public ?CategoryCollection $categories;     // collection that containst `Category` objects
    public ?Volume $volume;
    public ?Weight $weight;
}
```

For better readability are data separated to value objects.

```php
class Manufacturer
{
    public string $code;                        // manufacturer internal code
    public string $name;                        // manufacturer public name
    public ?Picture $picture;
}

class Pattern
{
    public string $name;
    public ?string $description;
    public ?string $season;
    public ?string $purpose;
    public ?Picture $picture;
    public ?PictureCollection $pictures;        // collection that containst `Picture` objects
}

class Parameter
{
    public string $code;                        // parameter internal code
    public string $name;                        // parameter public name
    public ?string $value;                      // parameter value
}

class Category
{
    public string $code;                        // category internal code
    public string $name;                        // category public name
}
```

Objects of `Pattern` and `Manufacturer` can contain pictures, which are represented by the `Picture` object.

```php
class Picture
{
    public string $uri;
}
```
Default size of each picture is 600×600px and is provided in JPG format. If you need a picture in a different size or format, you can use the built-in method:

```php
$resizedPicture      = $picture->withFormat(1000, 1000); 
$resizedPictureInPng = $picture->withFormat(800, 800, Picture::PNG); 
```

### Pricelist
To load pricelist call:

```php
$collection = $pricelist->load();
```

This returns a `PriceListCollection` that constains `ProductPricing` objects with next properties:

```php
class ProductPricing
{
    public string $code;                        // product code
    public ?PricePolicy $price;
}

class PricePolicy
{
    public Price $sale;                         // end-customer price
    public Price $purchase;                     // your purchase (discounted) price
}
```

### Stock
To load stock resources call:

```php
$collection = $stock->load();
```

This returns a `StockCollection` that constains `ProductStocks` objects with next properties:

```php
class ProductStocks
{
    public string $code;                        // product code
    public ?ResourceCollection $stock;          // collection that containst `StockResource` objects
}

class StockResource
{
    public string $code;                        // stock code
    public string $name;                        // stock name
    public int $days;                           // approximate delivery time from order confirmation 
    public int $quantity;                       // number of pcs in this stock
    public bool $moreThanQuantity;              // determines if quantity is exact or minimal
}
```