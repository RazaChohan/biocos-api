# Book or Update Order

    PUT /api/book-update-order/{orderId?}

## Description
Returns order object eager loading with products and quantities after storing/updating given order information 

## Request Headers
- **X-Auth-Token** — Authorization Token

## Parameter
- **OrderId** — Order Id is only required when a particular order needs to be updated

## Return format
A collection JSON object containing keys **Order** , **Products**

- **Order**  — Order object
- **Products**   —  Products and their corresponding quantities in order.


## Example
**Request**

    /api/book-update-order
**Json Body With Customer Object**
```javascript
{
	"customer"   : {  
                        "name"  			  :"Wood works",
                        "location"            :"Liberty Market Lahore",
                        "phone_1"             :"456456-56465-54",
                        "latitude"            :"31.577986",
                        "longitude"           :"74.317994",
                        "customer_type"       :"Wholesaler",
                        "shop_type"           :"Super Store",
                        "discount_percentage" :"Retail Saler",
                        "status"              :"Rejected",
                        "category"            :"D",
                        "proprietor"          :{
                                                "name"    : "Propreitor Name",
                                                "address" : "Propreitor Address",
                                                "email"   : "propreitor@biocospk.com",
                                                "landline": "landline-no",
                                                "phone_1" : "phone-1",
                                                "phone_2" : "phone-2"
						                       },
						    "contact_person"  :{
						                            "name"    : "Contact person Name",
						                            "address" : "Contact person Address",
						                            "email"   : "contact_person@biocospk.com",
						                            "landline": "landline-no",
						                            "phone_1" : "phone-1",
						                            "phone_2" : "phone-2"
						                          },
												   "phone_2"             :"55645-456645-44",
												   "email"               :"admin@biocospk.com",
												   "biocos_ratting"      :21.3,
												   "region_id"           :1
											},
	"status"	      : "Booked",
	"date_to_deliver" : "2017-08-15",
	"price"			  : "25.2",
	"products"		  : [
							{
								"product_id" : "1",
								"quantity"   : "3"
							},
							{
								"product_id" : "2",
								"quantity"   : "5"
							}
						],
	"type"			  : "Query"
}
```

**Json Body**
```javascript
{
	"customer_id"     : 1,
	"status"	      : "booked",
	"date_to_deliver" : "2017-08-15",
	"price"			  : "25.2",
	"products"		  : [
                {
                  "product_id" : "1",
                  "quantity"   : "3"
                },
                {
                  "product_id" : "2",
                   "quantity"   : "5"
                }
	],
	"type"			  : "query"
}
```

**Return** __shortened for example purpose__
``` json
{
    "success": true,
    "message": "Order Updated",
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
 
