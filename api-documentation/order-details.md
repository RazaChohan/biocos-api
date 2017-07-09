# Get Order Details

    GET /api/order-details/{ID}

## Description
Returns object of order depending upon the ID of order passed as parameters

## Headers
- **X-Auth-Token** — Authorization token of user


## Parameters
- **Order Id** — ID of order for which details are required


## Return format
A JSON object containing key **data**

- **Data** — Order object


## Example
**Request**

    /api/order-details/1

**Return** __shortened for example purpose__
``` json
{
    "success": true,
    "message": "Order found",
    "data": {
        "id": 10,
        "agency_id": null,
        "customer_id": 1,
        "status": "booked",
        "visit_id": 0,
        "date_to_deliver": "2017-08-15 00:00:00",
        "booked_by": 1,
        "price": 25.2,
        "discount": 0,
        "type": "query",
        "created_by": 1,
        "updated_by": 1,
        "deleted_by": 0,
        "created_at": "2017-07-09 15:07:11",
        "updated_at": "2017-07-09 15:15:00",
        "deleted_at": null,
        "products": [
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
                "discontinued_on": "2018-07-06 18:52:47",
                "description": "asdasd",
                "minimum_order_unit": 2,
                "minimum_ws_quantity": 2,
                "minimum_rs_quantity": 2,
                "created_by": 1,
                "updated_by": 1,
                "deleted_by": 1,
                "created_at": null,
                "updated_at": null,
                "deleted_at": null,
                "pivot": {
                    "order_id": 10,
                    "product_id": 1,
                    "quantity": 3
                }
            },
            {
                "id": 2,
                "agency_id": null,
                "name": "Serum",
                "product_code": "Cd-23",
                "category": "accessories",
                "type": "cream",
                "retail_price": 22.3,
                "wholesale_price": 20.3,
                "distributor_price": 25.33,
                "stock_available": 1,
                "started_on": "2017-06-09 14:59:09",
                "discontinued_on": "2018-07-09 14:59:22",
                "description": "asdasd",
                "minimum_order_unit": 5,
                "minimum_ws_quantity": 5,
                "minimum_rs_quantity": 5,
                "created_by": 1,
                "updated_by": 1,
                "deleted_by": 1,
                "created_at": null,
                "updated_at": null,
                "deleted_at": null,
                "pivot": {
                    "order_id": 10,
                    "product_id": 2,
                    "quantity": 5
                }
            }
        ]
    }
}
```
