# Simple array to XML converter
CreateXml provides XML creation from an array.

## Usage

```php
$data = array(
    '@attr' => ['id' => 1, 'name' => 'Name'],
    'head' => [
        '@attr' => ['id' => 2, 'title' => 'Title'],
        '@value' => 'Head value',
    ],
    'list' => [
        'item1' => [1, 2, 3],
        'item2' => [
            'item21' => [
                1,
                ['@attr' => ['id' => 2]],
                ['@attr' => ['id' => 3], '@value' => 'Item213 value'],
                ['item214' => 'Item214 value'],
            ],
        ],
        'item3' => 'Item3 value',
    ],
    'symbol' => [
        '@attr' => ['symbol' => '<angle> \'single\' "double"'],
        '@value' => '<angle> \'single\' "double"',
    ],
);
```

### Get as string
```php
CreateXml::get('main', $data);
```

### Save to file
```php
CreateXml::save(__DIR__.'/test.xml', 'main', $data);
```

## Result
```xml
<?xml version="1.0" encoding="UTF-8"?>
<main id="1" name="Name">
    <head id="2" title="Title">Head value</head>
    <list>
        <item1>1</item1>
        <item1>2</item1>
        <item1>3</item1>
        <item2>
            <item21>1</item21>
            <item21 id="2"/>
            <item21 id="3">Item213 value</item21>
            <item21>
                <item214>Item214 value</item214>
            </item21>
        </item2>
        <item3>Item3 value</item3>
    </list>
    <symbol symbol="&lt;angle&gt; 'single' &quot;double&quot;">&lt;angle&gt; 'single' "double"</symbol>
</main>
```
