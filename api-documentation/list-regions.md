# List Jobs

    POST /api/list-regions

## Description
Returns list of regions depending upon the parameters/filters passed

## Headers
- **X-Auth-Token** — Authorization token of user


## Parameters
- **user_id** — user id of user for which regions needs to be fetched (If this parameter is not passed user id will be used from X-Auth-Token)
- **region_id** — region Id,
- **sub_region** — sub region (true/false) fetch jobs for sub regions as well,
- **page** — Page number for pagination


## Return format
A collection JSON objects containing keys **regions**

- **Region** — Region object


## Example
**Request**

    /api/list-regions?user_id=1&region_id=1&sub_region=true&page=1

**Return** __shortened for example purpose__
``` json
{
    "success": false,
    "message": "Regions found",
    "data": [
        {
            "id": 1,
            "agency_id": null,
            "name": "Islamabad",
            "city": "Islamabad",
            "latitude": 2213.3,
            "longitude": 23.3,
            "country": "Pakistan",
            "parent_id": 0,
            "created_by": 1,
            "updated_by": 1,
            "deleted_by": 1,
            "created_at": "2017-06-18 17:07:52",
            "updated_at": "2017-06-18 17:07:56",
            "deleted_at": null
        },
        {
            "id": 3,
            "agency_id": null,
            "name": "Gujranwala",
            "city": "Gujranwala",
            "latitude": 23.4,
            "longitude": 3.4,
            "country": "Pakistan",
            "parent_id": 1,
            "created_by": 1,
            "updated_by": 1,
            "deleted_by": 1,
            "created_at": "2017-06-18 20:52:09",
            "updated_at": "2017-06-18 20:52:10",
            "deleted_at": null
        }
    ]
}
```
