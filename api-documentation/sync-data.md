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
                               },
    "status"          : "Booked",
    "date_to_deliver" : "2017-08-15",
    "price"           : "25.2",
    "uuid"            : "9c065f4f-ee20-467b-b704-946d45c8a3db",
    "remarks"         : "Remarks goes here",

    "products"        : [
                            {
                                "product_id" : "1",
                                "quantity"   : "3"
                            },
                            {
                                "product_id" : "2",
                                "quantity"   : "5"
                            }
                        ],
    "type"            : "Query"
}
    ],
    "regions"   : [
                        {
                            "uuid"      : "2f15c9db-ad84-4ff4-9597-6d7a37f8cf83",                                                       
                            "name"      : "Shah Alam Market",
                            "city"      : "Lahore",
                            "latitude"  : "31.44",
                            "longitude" : "74.52",
                            "country"   : "Pakistan",
                            "parent_id" : 1
                        }
    ],
    "user_regions": {
    	"update_region_model_list" : [
    		{
    			"date" : "05-09-2017",
    			"region_uuid" : "2f15c9db-ad84-4ff4-9597-6d7a37f8cf83"
    		}
    	 ],
    	"delete_assign_region_model_list" : [
    	    {
    	        "id" : 2,
    	        "delete" : true
    	    }
    	]
    }
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
                "id": 1,
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
                "status": "Rejected",
                "Category": "D",
                "created_by": 1,
                "updated_by": 1,
                "deleted_by": 0,
                "created_at": "2017-09-12 06:37:36",
                "updated_at": "2017-09-12 06:37:37",
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
                "id": 1,
                "uuid": "9c065f4f-ee20-467b-b704-946d45c8a3db",
                "agency_id": null,
                "customer_id": 1,
                "status": "Booked",
                "visit_id": 0,
                "date_to_deliver": "2017-08-15 00:00:00",
                "booked_by": 1,
                "price": 25.2,
                "discount": 0,
                "payment": null,
                "type": "Query",
                "delivery_time": null,
                "remarks": "Remarks goes here",
                "latitude": null,
                "longitude": null,
                "created_by": 1,
                "updated_by": 1,
                "deleted_by": 0,
                "created_at": "2017-09-12 06:37:37",
                "updated_at": "2017-09-12 07:07:30",
                "deleted_at": null,
                "products": [],
                "images": [],
                "customer": {
                    "id": 1,
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
                    "status": "Rejected",
                    "Category": "D",
                    "created_by": 1,
                    "updated_by": 1,
                    "deleted_by": 0,
                    "created_at": "2017-09-12 06:37:36",
                    "updated_at": "2017-09-12 06:37:37",
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
                "id": 1,
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
                "created_at": "2017-09-12 06:37:36",
                "updated_at": "2017-09-12 07:06:12",
                "deleted_at": null
            }
        ],
        "payments": [],
        "user_regions": [
            [
                {
                    "id": 1,
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
                    "created_at": "2017-09-12 06:37:36",
                    "updated_at": "2017-09-12 07:06:12",
                    "deleted_at": null,
                    "pivot": {
                        "user_id": 1,
                        "region_id": 1,
                        "date": "2017-09-05",
                        "execution_time": "00:00:00",
                        "id": 1
                    }
                }
            ]
        ]
    }
}
```
 
