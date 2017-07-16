# Update Profile

    PUT /api/update-profile/{userId}

## Description
Returns user object with regions after updating given information 

## Request Headers
- **X-Auth-Token** — Authorization Token

## Parameter
- **UserId** — User Id is only required when a particular profile needs to be updated

## Return format
A JSON object containing key **User** 

- **User**  — User object


## Example
**Request**

    /api/update-profile

**Json Body**
```javascript
{  
   "firstname"           :"Muhammad",
   "lastname"            :"Raza",
   "username"            :"mhraza",
   "email"               :"mraza@xynoapps.com",
   "phone_1"             :"456456-56465-54",
   "phone_2"             :"55645-456645-44"
}
```

**Return** __shortened for example purpose__
``` json
{
    "success": true,
    "message": "User Updated",
    "data": {
        "id": 1,
        "firstname": "Muhammad",
        "lastname": "Raza",
        "email": "mraza@xynoapps.com",
        "reset_token": null,
        "profile_image": null,
        "agency_id": null,
        "remember_token": null,
        "user_type": "Sub Admin",
        "username": "mhraza",
        "phone_1": "456456-56465-54",
        "phone_2": "55645-456645-44",
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