<?php

return [
    'name' => 'Name',
    'slug' => 'URL',
    'description' => 'Description',
    'short_description' => 'Short Description',
    'brand_id' => 'Brand',
    'categories' => 'Categories',
    'tax_class_id' => 'Tax Class',
    'tags' => 'Tags',
    'is_virtual' => 'Virtual',
    'is_active' => 'Status',
    'price' => 'Price',
    'special_price' => 'Special Price',
    'special_price_type' => 'Special Price Type',
    'special_price_start' => 'Special Price Start',
    'special_price_end' => 'Special Price End',
    'sku' => 'SKU',
    'manage_stock' => 'Inventory Management',
    'qty' => 'Qty',
    'in_stock' => 'Stock Availability',
    'new_from' => 'New From',
    'new_to' => 'New To',
    'up_sells' => 'Up-Sells',
    'cross_sells' => 'Cross-Sells',
    'related_products' => 'Related Products',

    # product attributes
    'attributes' => [
        '*.attribute_id' => 'Attribute',
        '*.values' => 'Values',
    ],

    # product options
    'options' => [
        '*.name' => 'Name',
        '*.type' => 'Type',
        '*.values.*.label' => 'Label',
        '*.values.*.price' => 'Price',
        '*.values.*.price_type' => 'Price Type',
    ],

    # product variations
    'variations' => [
        '*.name' => 'Name',
        '*.type' => 'Type',
        '*.values' => 'Values',
        '*.values.*.label' => 'Label',
        '*.values.*.color' => 'Color',
        '*.values.*.image' => 'Image',
    ],

    # product variants
    'variants' => [
        '*.name' => 'Name',
        '*.sku' => 'SKU',
        '*.is_active' => 'Status',
        '*.is_default' => 'Default',
        '*.price' => 'Price',
        '*.special_price' => 'Special Price',
        '*.special_price_type' => 'Special Price Type',
        '*.special_price_start' => 'Special Price Start',
        '*.special_price_end' => 'Special Price End',
        '*.manage_stock' => 'Inventory Management',
        '*.qty' => 'Quantity',
        '*.in_stock' => 'Stock Availability',
    ],
];
