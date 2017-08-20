# Add or Update Customer

    PUT /api/add-update-customer/{customerId?}

## Description
Returns customer object after storing/updating given customer information 

## Request Headers
- **X-Auth-Token** � Authorization Token
- **Content-Type** � application/json


## Parameter
- **CustomerId** � Customer Id is only required when a particular customer needs to be updated

## Return format
A JSON object containing key **Customer** 

- **Customer**  � Customer object


## Example
**Request**

    /api/add-update-customer

**Json Body with Contact Person & Proprietor Objects**
```javascript
{  
   "uuid"                :"55c143cd-1ec9-4566-86bd-030db960434f",
   "name"                :"Wood works",
   "location"            :"Liberty Market Lahore",
   "phone_1"             :"456456-56465-54",
   "latitude"            :"31.577986",
   "longitude"           :"74.317994",
   "customer_type"       :"wholesaler",
   "shop_type"           :"Super store",
   "discount_percentage" :"retail saler",
   "status"              :"rejected",
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
   "region_id"           :1,
   "images"              : [
       "image-1-hash",
       "image-2-hash"
   ],
   "remove_images"      : [
        "image-1-full-path",
        "image-2-full-path"
   ]
}
```

**Json Body with Contact Person and Proprietor ID**
```javascript
{  
   "name"                :"Wood works",
   "location"            :"Liberty Market Lahore",
   "phone_1"             :"456456-56465-54",
   "latitude"            :"31.577986",
   "longitude"           :"74.317994",
   "customer_type"       :"wholesaler",
   "shop_type"           :"Super store",
   "discount_percentage" :"retail saler",
   "status"              :"rejected",
   "category"            :"D",
   "proprietor_id"       :1,
   "contact_person_id"   :12,
   "phone_2"             :"55645-456645-44",
   "email"               :"admin@biocospk.com",
   "biocos_ratting"      :21.3,
   "region_id"           :1,
   "images"              : [
       "image-1-hash",
       "image-2-hash"
   ],
   "remove_images"      : [
        "image-1-full-path",
        "image-2-full-path"
   ]
}
```

**Return** __shortened for example purpose__
``` json
{
    "success": true,
    "message": "Customer Updated",
    "data": {
        "id": 4,
        "agency_id": null,
        "name": "Wood works",
        "proprietor_id": 1,
        "contact_person_id": 12,
        "location": "Liberty Market Lahore",
        "latitude": 31.577986,
        "longitude": 74.317994,
        "phone_1": "456456-56465-54",
        "phone_2": "55645-456645-44",
        "email": "admin@biocospk.com",
        "type": "wholesaler",
        "industry": "Super store",
        "discount_percentage": "retail saler",
        "biocos_ratting": 21.3,
        "region_id": 1,
        "status": "rejected",
        "Category": "D",
        "created_by": 1,
        "updated_by": 1,
        "deleted_by": 0,
        "created_at": "2017-07-09 20:58:14",
        "updated_at": "2017-07-09 20:59:13",
        "deleted_at": null
    }
}
```
 
