# List Orders

    GET /api/list-orders

## Description
Returns list of orders depending upon the parameters/filters passed

## Headers
- **X-Auth-Token** — Authorization token of user


## Parameters
- **user_id** — user id of user for which orders booked needs to be fetched (If this parameter is not passed user id will be used from X-Auth-Token)
- **region_id** — region Id for which orders needs to be fetched
- **sub_region** — sub region (true/false) fetch orders for sub regions as well
- **page** — Page number for pagination


## Return format
A collection JSON objects containing keys **customers**

- **Order** — Order object


## Example
**Request**

    /api/list-orders?user_id=1&region_id=1&sub_region=true&page=2

**Return** __shortened for example purpose__
``` json
{
    "success": true,
    "message": "Orders found",
    "data": [
        {
            "id": 11,
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
            "updated_by": 0,
            "deleted_by": 0,
            "created_at": "2017-07-09 15:14:28",
            "updated_at": "2017-07-09 15:14:28",
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
                        "order_id": 11,
                        "product_id": 1,
                        "quantity": 3
                    }
                }
            ]
        },
        {
            "id": 12,
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
            "updated_by": 0,
            "deleted_by": 0,
            "created_at": "2017-07-09 20:32:37",
            "updated_at": "2017-07-09 20:32:37",
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
                        "order_id": 12,
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
                        "order_id": 12,
                        "product_id": 2,
                        "quantity": 5
                    }
                }
            ]
        }
    ]
}
```
