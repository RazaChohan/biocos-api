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
	"user_regions" : [
		 {
    	   "id" : 1,
    	   "region_uuid": "2f15c9db-ad84-4ff4-9597-6d7a37f8cf83",
           "date" : "2017-09-19",
           "execution_time" : "12:00:19"
         },
         {
    	    "region_uuid" : "18cecfb5-8825-45fa-9622-501dc3ba14fe",
    	    "date" : "2017-09-07"
         }
	]
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
    "message": "Records Created"
}
```
 
