# pazarama
Pazarama PHP API

## Kurulum

```
composer require bluntk/pazarama
```

## Ayarlar

```php
$pazarama = new \bluntk\Pazarama([
            'api_key' => $this->apiKey,
            'api_secret' => $this->apiSecret
]);
```
      
## Kategori Ağacı

```php
$categoryTree = $pazarama->categories();
```

## Markalar

```php
$brands = $pazarama->brands(page: 1, size: 10);
```

## Attributeleri ile kategori
```php
$categoryWithAttributes = $pazarama->categoryWithAttributes($id);
```

## Teslimat Adresleri
```php
$sellerDeliveries = $pazarama->sellerDeliveries();
```

## Şehirler
```php
$cities = $pazarama->cities();
```

## Ürün Ekleme
```php
$data = [
        'Name' => 'Name',
        'DisplayName' => 'Display Name',
        'Description' => 'Description',
        'BrandId' => 'Marka ID',
        'Desi' => 1,
        'Code' => 'Barkod',
        'GroupCode' => 'Grup Kodu', // Gruplandırma için ana barkod
        'StockCount' => 'Stok sayısı',
        'VatRate' => 'Vergi Oranı',
        'ListPrice' => 'Liste Fiyatı',
        'SalePrice' => 'Satış Fiyatı',
        'CategoryId' => 'Kategori ID',
        'images' => [
            ['imageurl' => 'görsel url'],
            ['imageurl' => 'görsel url2']
        ],
        'attributes' => [
            [
                'attributeId' => 'AttributeID',
                'attributeValueId' => 'Attribute Value ID',
            ],
           [
                'attributeId' => 'AttributeID',
                'attributeValueId' => 'Attribute Value ID',
            ],
        ],
    ];
$product = $pazarama->createProduct();
```


## Batch Request Sorgulama

```php
$pazarama->productBatchRequest($batchRequestId);
```

### Diğer servisleri de sınıfın içinde görebilirsiniz. Kullanımları aynıdır. Gönderilecek parametreler pazarama api dökümanında yer aldığı gibidir.
