# List User Locations

    GET /api/list-user-locations

## Description
Returns list of user locations depending upon the parameters/filters passed

## Headers
- **X-Auth-Token** — Authorization token of user


## Parameters
- **user_id** — user id of user for which locations needs to be fetched (If this parameter is not passed user id will be used from X-Auth-Token)


## Return format
A collection JSON objects containing keys **locations**

- **Locations** — Location object


## Example
**Request**

    /api/list-regions?user_id=1&page=1

**Return** __shortened for example purpose__
``` json
{
    "success": true,
    "message": "User Locations found",
    "data": [
        {
            "id": 1,
            "user_id": 1,
            "latitude": 25.5,
            "longitude": 22.2,
            "date": "2017-08-15 12:34:00"
        },
        {
            "id": 2,
            "user_id": 1,
            "latitude": 74.6,
            "longitude": 85.6,
            "date": "2017-07-14 23:10:00"
        }
    ]
}
```
