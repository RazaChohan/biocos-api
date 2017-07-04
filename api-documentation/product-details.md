# Get Product Details

    GET /api/product-details/{ID}

## Description
Returns object of product depending upon the ID of product passed as parameters

## Headers
- **X-Auth-Token** — Authorization token of user


## Parameters
- **Product Id** — ID of product for which details are required,


## Return format
A JSON object containing key **data**

- **Data** — Product object


## Example
**Request**

    /api/product-details/1

**Return** __shortened for example purpose__
``` json
{
    "success": true,
    "message": "Product found",
    "data": {
        "id": 1,
        "agency_id": null,
        "name": "Cream",
        "product_code": "Cd-22",
        "category": "accessories",
        "type": "cream",
        "retail_price": 22.3,
        "wholesale_price": 20.3,
        "distributor_price": 25.33,
        "stock_available": 1,
        "started_on": "2017-07-01 18:25:06",
        "discontinued_on": "2017-07-06 18:52:47",
        "description": "asdasd",
        "minimum_order_unit": 2,
        "minimum_ws_quantity": 2,
        "minimum_rs_quantity": 2,
        "created_by": 1,
        "updated_by": 1,
        "deleted_by": 1,
        "created_at": null,
        "updated_at": null,
        "deleted_at": null
    }
}
```
