# List Products

    GET /api/list-products

## Description
Returns list of products depending upon the parameters/filters passed
- **Agency of user**
- **Started date of product**

## Headers
- **X-Auth-Token** — Authorization token of user


## Parameters
- **user_id** — user id of user for which products needs to be fetched (If this parameter is not passed user id will be used from X-Auth-Token)
- **page** — Page number for pagination


## Return format
A collection JSON objects containing keys **products**

- **Product** — Product object


## Example
**Request**

    /api/list-products?page=1

**Return** __shortened for example purpose__
``` json
{
    "success": true,
    "message": "Products found",
    "data": [
        {
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
    ]
}
```
