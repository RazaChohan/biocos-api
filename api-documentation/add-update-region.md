# Add or Update Region

    PUT /api/add-update-region/{regionId?}

## Description
Returns region object after storing/updating given information 

## Request Headers
- **X-Auth-Token** — Authorization Token

## Parameter
- **RegionId** — Region Id is only required when a particular region needs to be updated

## Return format
A JSON object containing key **Region** 

- **Region**  — Region object


## Example
**Request**

    /api/add-update-region

**Json Body**
```javascript
{  
   "name"                :"Wood works",
   "location"            :"Liberty Market Lahore",
   "phone_1"             :"456456-56465-54",
   "latitude"            :"31.577986",
   "longitude"           :"74.317994",
   "type"                :"wholesaler",
   "industry"            :"Super store",
   "discount_percentage" :"retail saler",
   "status"              :"rejected",
   "category"            :"D",
   "proprietor_id"       :1,
   "contact_person_id"   :12,
   "phone_2"             :"55645-456645-44",
   "email"               :"admin@biocospk.com",
   "biocos_ratting"      :21.3,
   "region_id"           :1
}
```

**Return** __shortened for example purpose__
``` json
{
    "success": true,
    "message": "Region Updated",
    "data": {
        "id": 2,
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
        "created_at": "2017-07-09 22:13:42",
        "updated_at": "2017-07-09 22:15:00",
        "deleted_at": null
    }
}
```