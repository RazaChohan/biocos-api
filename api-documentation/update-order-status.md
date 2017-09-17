# Update order status

    POST /api/update-order-status

## Description
Update status of order by passing order id in body 

## Request Headers
- **X-Auth-Token** Authorization Token
- **Content-Type** application/json

## Example
**Request**

    /api/update-order-status

**Json Body**
```javascript
{
	"order_id" : 2,
	"status":    'Rejected',
	"remarks" : 'Remarks goes here...'
}
```

**Return** __shortened for example purpose__
``` json
{
    "success": true,
    "message": "Order Status Updated",
    "data": {
        "id": 3,
        "uuid": "",
        "agency_id": null,
        "customer_id": 13,
        "status": "Rejected",
        "visit_id": 0,
        "date_to_deliver": "2017-08-15 00:00:00",
        "booked_by": 1,
        "price": 25.2,
        "discount": 0,
        "payment": null,
        "type": "Query",
        "delivery_time": null,
        "remarks": "My remarks....",
        "latitude": null,
        "longitude": null,
        "created_by": 1,
        "updated_by": 1,
        "deleted_by": 0,
        "created_at": "2017-07-30 08:28:25",
        "updated_at": "2017-09-17 14:52:29",
        "deleted_at": null,
        "products": [
            {
                "id": 1,
                "agency_id": null,
                "name": "Cream",
                "product_code": "CC-304",
                "category": "Accessories",
                "type": "Cream",
                "retail_price": 120,
                "wholesale_price": 100,
                "distributor_price": 140,
                "stock_available": 1,
                "started_on": "2017-08-04 12:07:49",
                "discontinued_on": "2018-08-04 12:07:52",
                "description": "Test",
                "minimum_order_unit": 5,
                "minimum_ws_quantity": 5,
                "minimum_rs_quantity": 5,
                "created_by": 1,
                "updated_by": 1,
                "deleted_by": 0,
                "created_at": "2017-08-04 07:08:15",
                "updated_at": "2017-08-04 07:08:16",
                "deleted_at": null,
                "pivot": {
                    "order_id": 3,
                    "product_id": 1,
                    "quantity": 3
                },
                "images": []
            }
        ],
        "images": [],
        "customer": {
            "id": 13,
            "uuid": "wedee46545w6eewd5ew4d",
            "agency_id": null,
            "name": "Wood works",
            "proprietor_id": 2,
            "contact_person_id": 3,
            "location": "Liberty Market Lahore",
            "latitude": 31.577986,
            "longitude": 74.317994,
            "phone_1": "456456-56465-54",
            "phone_2": "55645-456645-44",
            "email": "admin@biocospk.com",
            "customer_type": "Wholesaler",
            "shop_type": "Super Store",
            "discount_percentage": "Retail Saler",
            "biocos_ratting": 21.3,
            "region_id": 6,
            "status": "",
            "Category": "D",
            "created_by": 1,
            "updated_by": 0,
            "deleted_by": 0,
            "created_at": "2017-08-29 04:44:46",
            "updated_at": "2017-08-29 04:44:46",
            "deleted_at": null,
            "images": [],
            "contact_person": {
                "id": 3,
                "firstname": "Contact person",
                "lastname": "Name",
                "email": "contact_person@biocospk.com",
                "reset_token": null,
                "profile_image": null,
                "agency_id": null,
                "remember_token": null,
                "user_type": "Employee",
                "username": "",
                "phone_1": "phone-1",
                "phone_2": "phone-2",
                "parent_id": 0,
                "address": "Contact person Address",
                "landline": "landline-no"
            },
            "proprietor": {
                "id": 2,
                "firstname": "Propreitor",
                "lastname": "Name",
                "email": "propreitor@biocospk.com",
                "reset_token": null,
                "profile_image": null,
                "agency_id": null,
                "remember_token": null,
                "user_type": "Employee",
                "username": "",
                "phone_1": "phone-1",
                "phone_2": "phone-2",
                "parent_id": 0,
                "address": "Propreitor Address",
                "landline": "landline-no"
            }
        }
    }
}
```
**Possible Status Values**
 
 - Rejected
 - Booked
 - Confirmed
 - Processed
 - Ready
 - Delivered
 - Cleared
 - Rejected
 - Cancelled
