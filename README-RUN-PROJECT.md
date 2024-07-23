# Run project

## Requirements
 - Docker

## Start the project
1. run command in terminal `docker-compose up --build`
2. run command in terminal `composer dump-autoload`

## Usage of API

- send get request to `http://localhost:8080/orders/discounts` with the following payload as json and have Content-Type: application/json header:
  {
  "orders": [
    {
      "id": 1,
      "customer-id": 1,
      "items": [
        {
          "product-id": 1,
          "quantity": 1,
          "unit-price": 100,
          "total": 100
        }
      ],
      "total": 100
    }
  ],
  }
