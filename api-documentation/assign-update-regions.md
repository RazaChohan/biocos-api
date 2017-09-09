# Assign or Update User Regions

    PUT /api/assign-update-regions

## Description
Returns regions object after assigning/updating regions for particular user. The pivot object with region contains date of user regions

## Request Headers
- **X-Auth-Token** � Authorization Token
- **Content-Type** � application/json

## Return format
A JSON object containing key **Regions** 

- **Region**  � Region object


## Example
**Request**

    /api/assign-update-regions

**Json Body**
```javascript
{ 
	"update_region_model_list" : 
	[
		{
			"region_id": 1,
			"date" : "05-10-2019"
		},
		{
			"id"	   : 29,
		    "region_id": 2,
			"date" : "09-12-2019"
		}
	],
	"delete_assign_region_model_list" : 
	[
		{
			"id" : 31,
			"delete" : true
		},
		{
			"id" : 32,
			"delete" :true
		}
	]
}


```
**Return** __shortened for example purpose__
``` json
{
    "success": true,
    "message": "User Regions Updated",
    "data": [
        {
            "id": 1,
            "uuid": "",
            "agency_id": null,
            "name": "Shalmi",
            "city": "Lahore",
            "latitude": 32.3,
            "longitude": 23.21,
            "country": "Lahore",
            "parent_id": 1,
            "created_by": 1,
            "updated_by": 1,
            "deleted_by": 1,
            "created_at": null,
            "updated_at": null,
            "deleted_at": null,
            "pivot": {
                "user_id": 1,
                "region_id": 1,
                "date": "2017-10-27",
                "execution_time" : "52:00"
            }
        },
        {
            "id": 2,
            "uuid": "",
            "agency_id": null,
            "name": "Shah Alam Market",
            "city": "Lahore",
            "latitude": 31.44,
            "longitude": 74.52,
            "country": "Pakistan",
            "parent_id": 1,
            "created_by": 1,
            "updated_by": 1,
            "deleted_by": 1,
            "created_at": null,
            "updated_at": "2017-07-31 21:07:39",
            "deleted_at": null,
            "pivot": {
                "user_id": 1,
                "region_id": 2,
                "date": "2017-09-26",
                "execution_time" : "52:00"
            }
        }
    ]
}
```
 
