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
    
**Json Body With Customers, Regions & Orders**
```javascript
{
	"customers" : [
				{  
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
	"type"			  : "Query"
}
	],
	"regions"   : [
						{
							"name"      : "Shah Alam Market",
							"city"      : "Lahore",
							"latitude"  : "31.44",
							"longitude" : "74.52",
							"country"   : "Pakistan",
							"parent_id" : 1
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
 
