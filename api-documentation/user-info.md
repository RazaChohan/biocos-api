# Get User Info with Regions

    GET /user-info/{userId} - User Id is optional

## Description
Returns user object with regions

## Parameters
- **userId** — User id

## Return format
A JSON object containing keys **user** , **regions** collections

- **User**      —  User object containing attributes related to user .
- **Regions**   —  Collection of regions


## Example
**Request**

    /user-info/{userId} (User id is optional if not provided user 
                                   ID from auth token will be used)

**Return** __shortened for example purpose__
``` json
{
    "success": true,
    "message": "User found",
    "data": {
        "id": 1,
        "firstname": "Muhammad",
        "lastname": "Raza",
        "email": "razachohan@gmail.com",
        "reset_token": null,
        "profile_image": null,
        "agency_id": null,
        "remember_token": null,
        "user_type": "Sub Admin",
        "username": "razachohan",
        "phone_1": "",
        "phone_2": "",
        "parent_id": 0,
        "regions": [
            {
                "id": 1,
                "agency_id": null,
                "name": "Shalmi",
                "city": "Lahore",
                "latitude": 22.3,
                "longitude": 55.2,
                "country": "Pakistan",
                "parent_id": 1,
                "created_by": 1,
                "updated_by": 1,
                "deleted_by": 1,
                "created_at": null,
                "updated_at": null,
                "deleted_at": null,
                "pivot": {
                    "user_id": 1,
                    "region_id": 1
                }
            }
        ]
    }
}
```
