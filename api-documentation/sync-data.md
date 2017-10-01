# Sync Data

    PUT /api/sync-data

## Description
Sync Data of regions, orders and customers in bulk

## Request Headers
- **X-Auth-Token** — Authorization Token

## Return format
Status whether records are created successfully

## Example
**Request**

    /api/sync-data
    
**Json Body With Customers, Regions, Payments, User Regions & Orders**
```javascript
{
	"customers" : [
				{  
				   "uuid"                :"55c143cd-1ec9-4566-86bd-030db960434f",
				   "name"                :"Wood works",
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
				   "contact_person"      :{
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
				}
	],
	"orders"    : [
		{
				"customer":   {  
							    "uuid"                : "9c065f4f-ee20-467b-b704-946d45c8a3db",
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
							    "contact_person"      :{
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
	"type"			  : "Query",
	"uuid"			  : "9c065f4f-ee20-467b-b704-946d45c8a3db"
}
	],
	"regions"   : [
						{
							"uuid"      : "18cecfb5-8825-45fa-9622-501dc3ba14fe",
							"name"      : "Shah Alam Market",
							"city"      : "Lahore",
							"latitude"  : "31.44",
							"longitude" : "74.52",
							"country"   : "Pakistan",
							"parent_id" : 1
					    }
	],
	"payments"  : [
	{
		"uuid"		    : "1c61e74c-5909-4ce2-a0c3-7eda9c2a8ba6",
		"customer_uuid" : "55c143cd-1ec9-4566-86bd-030db960434f",
		"order_uuid"    : "9c065f4f-ee20-467b-b704-946d45c8a3db",
		"remarks"	    : "Remarks goes here...",
		"payment_type"  : "Cheque", 
		"amount"	    : 562.6,
		"is_success"    : true,
	    "promise_cheque_date" : "2017-05-12",
		"cheque_type"	: "Bearer Cheque",
		"cheque_no"		: "wede4redw43432423-234dwdwd"
	},
	{
		"uuid"		    : "1c61e74c-5909-4ce2-a0c3-7eda9c2a8ba3",
		"customer_id"   : "1",
		"order_id"	    : "3",
		"remarks"	    : "Remarks goes here...",
		"payment_type"  : "Cheque", 
		"amount"	    : 562.6,
	    "promise_cheque_date" : "2017-05-12",
		"cheque_type"	: "Bearer Cheque",
		"cheque_no"		: "wede4redw43432423-234dwdwd"
	}
	],
	"user_regions" : 
	{
			"update_region_model_list" : 
			[
				{
		    	   "region_uuid": "2f15c9db-ad84-4ff4-9597-6d7a37f8cf83",
		           "date" : "2017-09-19",
		           "execution_time" : "12:00:19"
		    	},
		    	{
		    		"region_uuid" : "18cecfb5-8825-45fa-9622-501dc3ba14fe",
		    		"date" : "2017-09-07"
		    	}
	    	],
	    	"delete_assign_region_model_list" :
	    	[
	    		{
	    			"id" : 33,
	    			"delete" : "true"
	    		}
	    	]
		},
	"no_orders" : [
					{
						"customer_uuid": "55c143cd-1ec9-4566-86bd-030db960434f",
						"date"       : "05-09-2019",
						"latitude"	 : 20.55,
						"longitude"  : 105.55,
						"reason"     : "Reason goes here",
						"remarks"	 : "Remarks goes here..",
						"region_id"  : 2,
						"time"		 : "15:12",
						"uuid"		 : "sdfsd234dssdvdvdfvdsvd"
					}
	],
	"revisits"	: [
					{
						"customer_uuid": "55c143cd-1ec9-4566-86bd-030db960434f",
						"date"       : "05-09-2019",
						"latitude"	 : 20.55,
						"longitude"  : 105.55,
						"region_id"  : 2,
						"time"		 : "15:12",
						"uuid"		 : "sdfsd234dssdvdvdfvdsvd",
						"completed_on" : "05-10-2020"
					}
	]
}
```

**Return** __shortened for example purpose__
``` json
{
    "success": true,
    "message": "Records Created/Updated",
    "data": {
        "customers": [
            {
                "id": 4,
                "uuid": "55c143cd-1ec9-4566-86bd-030db960434f",
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
                "region_id": 1,
                "status": "",
                "Category": "D",
                "created_by": 1,
                "updated_by": 1,
                "deleted_by": 0,
                "created_at": "2017-08-20 11:53:47",
                "updated_at": "2017-10-01 12:10:22",
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
        ],
        "orders": [
            {
                "id": 2,
                "uuid": "9c065f4f-ee20-467b-b704-946d45c8a3db",
                "agency_id": null,
                "customer_id": 14,
                "status": "Booked",
                "visit_id": 0,
                "date_to_deliver": "2017-08-15 00:00:00",
                "booked_by": 1,
                "price": 25.2,
                "discount": 0,
                "payment": null,
                "type": "Query",
                "delivery_time": null,
                "remarks": null,
                "latitude": null,
                "longitude": null,
                "created_by": 1,
                "updated_by": 1,
                "deleted_by": 0,
                "created_at": "2017-10-01 12:08:50",
                "updated_at": "2017-10-01 12:10:22",
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
                            "order_id": 2,
                            "product_id": 1,
                            "quantity": 3
                        },
                        "images": []
                    }
                ],
                "images": [],
                "customer": {
                    "id": 14,
                    "uuid": "9c065f4f-ee20-467b-b704-946d45c8a3db",
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
                    "region_id": 1,
                    "status": "",
                    "Category": "D",
                    "created_by": 1,
                    "updated_by": 1,
                    "deleted_by": 0,
                    "created_at": "2017-09-06 22:22:13",
                    "updated_at": "2017-10-01 12:10:22",
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
        ],
        "regions": [
            {
                "id": 9,
                "uuid": "18cecfb5-8825-45fa-9622-501dc3ba14fe",
                "agency_id": null,
                "name": "Shah Alam Market",
                "city": "Lahore",
                "latitude": 31.44,
                "longitude": 74.52,
                "country": "Pakistan",
                "parent_id": 1,
                "created_by": 1,
                "updated_by": 1,
                "deleted_by": 0,
                "created_at": "2017-08-20 11:58:58",
                "updated_at": "2017-09-06 22:17:01",
                "deleted_at": null
            }
        ],
        "payments": [
            {
                "id": 9,
                "uuid": "1c61e74c-5909-4ce2-a0c3-7eda9c2a8ba6",
                "customer_id": 4,
                "user_id": 1,
                "remarks": "Remarks goes here...",
                "payment_type": "Cheque",
                "amount": 562.6,
                "promise_cheque_date": "2017-05-12",
                "cheque_type": "Bearer Cheque",
                "cheque_no": "wede4redw43432423-234dwdwd",
                "is_success": 1,
                "order_id": 0,
                "images": []
            },
            {
                "id": 10,
                "uuid": "1c61e74c-5909-4ce2-a0c3-7eda9c2a8ba3",
                "customer_id": 1,
                "user_id": 1,
                "remarks": "Remarks goes here...",
                "payment_type": "Cheque",
                "amount": 562.6,
                "promise_cheque_date": "2017-05-12",
                "cheque_type": "Bearer Cheque",
                "cheque_no": "wede4redw43432423-234dwdwd",
                "is_success": 0,
                "order_id": 1,
                "images": []
            }
        ],
        "user_regions": [
            [
                {
                    "id": 10,
                    "uuid": "2f15c9db-ad84-4ff4-9597-6d7a37f8cf83",
                    "agency_id": null,
                    "name": "Shah Alam Market",
                    "city": "Lahore",
                    "latitude": 31.44,
                    "longitude": 74.52,
                    "country": "Pakistan",
                    "parent_id": 1,
                    "created_by": 1,
                    "updated_by": 1,
                    "deleted_by": 0,
                    "created_at": "2017-08-20 12:28:25",
                    "updated_at": "2017-08-20 12:29:37",
                    "deleted_at": null,
                    "pivot": {
                        "user_id": 1,
                        "region_id": 10,
                        "date": "2017-09-19",
                        "execution_time": "12:00:19",
                        "id": 6
                    }
                },
                {
                    "id": 9,
                    "uuid": "18cecfb5-8825-45fa-9622-501dc3ba14fe",
                    "agency_id": null,
                    "name": "Shah Alam Market",
                    "city": "Lahore",
                    "latitude": 31.44,
                    "longitude": 74.52,
                    "country": "Pakistan",
                    "parent_id": 1,
                    "created_by": 1,
                    "updated_by": 1,
                    "deleted_by": 0,
                    "created_at": "2017-08-20 11:58:58",
                    "updated_at": "2017-09-06 22:17:01",
                    "deleted_at": null,
                    "pivot": {
                        "user_id": 1,
                        "region_id": 9,
                        "date": "2017-09-07",
                        "execution_time": "00:00:00",
                        "id": 7
                    }
                }
            ]
        ],
        "deleted_user_regions": [
            33
        ],
        "no_orders": [
            {
                "id": 25,
                "agency_id": null,
                "region_id": 2,
                "date": "2019-09-05 00:00:00",
                "customer_id": 4,
                "user_id": 1,
                "job_type": "no-order",
                "status": "Completed",
                "completed_on": "2019-09-05 00:00:00",
                "employee_location": "",
                "visit_type": null,
                "comment": "Remarks goes here..",
                "order": 0,
                "created_by": 1,
                "updated_by": 1,
                "deleted_by": null,
                "created_at": "2017-10-01 12:10:20",
                "updated_at": "2017-10-01 12:10:23",
                "deleted_at": null,
                "uuid": "sdfsd234dssdvdvdfvdsvd",
                "longitude": 105.55,
                "latitude": 20.55,
                "reason": "Reason goes here",
                "time": "15:12:00",
                "images": []
            }
        ],
        "revists": [
            {
                "id": 25,
                "agency_id": null,
                "region_id": 2,
                "date": "2019-09-05 00:00:00",
                "customer_id": 4,
                "user_id": 1,
                "job_type": "revisit",
                "status": "Completed",
                "completed_on": "2019-09-05 00:00:00",
                "employee_location": "",
                "visit_type": null,
                "comment": "revisit",
                "order": 0,
                "created_by": 1,
                "updated_by": 1,
                "deleted_by": null,
                "created_at": "2017-10-01 12:10:20",
                "updated_at": "2017-10-01 12:10:23",
                "deleted_at": null,
                "uuid": "sdfsd234dssdvdvdfvdsvd",
                "longitude": 105.55,
                "latitude": 20.55,
                "reason": "Reason goes here",
                "time": "15:12:00",
                "images": []
            }
        ]
    }
}
```
 
