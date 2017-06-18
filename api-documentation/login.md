# Login

    POST /api/login

## Description
Returns authenticated user object

## Parameters
- **username** — user name of user
- **password** — password of user,

## Return format
A collection JSON objects containing keys **token** , **user object**

- **Token** — Auth Token to be used for authorization
- **user**    —  User object containing attributes related to user .


## Example
**Request**

    /api/login
**Json Body**
``` json
{
 "username" :  "razachohan",
 "password"  :  "ABC123ssi"
}
```

**Return** __shortened for example purpose__
``` json
{
    "success": true,
    "data": {
        "token": "fab1e14d-345e-43a6-b61f-00818c6eef4e",
        "user": {
            "id": 2,
            "firstname": "Muhammad",
            "lastname": "Raza",
            "email": "razachohan@live.com",
            "reset_token": null,
            "profile_image": null,
            "agency_id": null,
            "user_type": "Sub Admin",
            "username": "razachohan",
            "phone_1": "",
            "phone_2": "",
            "parent_id": 0
        }
        "regions": [
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
                            "deleted_at": null,
                            "pivot": {
                                "user_id": 2,
                                "region_id": 1
                            }
                        },
                        {
                            "id": 2,
                            "agency_id": null,
                            "name": "Lahore",
                            "city": "Lahore",
                            "latitude": 22.3,
                            "longitude": 23.44,
                            "country": "Pakistan",
                            "parent_id": 0,
                            "created_by": 1,
                            "updated_by": 1,
                            "deleted_by": 1,
                            "created_at": "2017-06-18 17:18:20",
                            "updated_at": "2017-06-18 17:18:26",
                            "deleted_at": null,
                            "pivot": {
                                "user_id": 2,
                                "region_id": 2
                            }
                        }
                    ]
    }
}
```
