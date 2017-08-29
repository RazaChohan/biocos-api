# List User Regions

    GET /api/list-user-regions

## Description
Returns list of user regions with pivot containing date

## Headers
- **X-Auth-Token** — Authorization token of user


## Return format
A collection JSON objects containing keys **regions**

- **Region** — Region object


## Example
**Request**

    /api/list-user-regions

**Return** __shortened for example purpose__
``` json
{
    "success": true,
    "message": "User Regions found",
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
                "execution_time" : "55:00"
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
