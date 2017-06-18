# Register User

    POST /api/register

## Description
Returns token for authorization of user after logging in the user to the system and returns the user object.

## Parameters
- **firstname** — First name of user
- **lastname** — Last name of user
- **email**	  — email of user
- **password** — password of user,
- **user_type** — type of user

## Return format
A collection JSON objects containing keys **token** , **user object**

- **Token** — Auth Token to be used for authorization
- **user**    —  User object containing attributes related to user .


## Example
**Request**

    /api/register
**Json Body**
``` json
{
 "firstname" :  "Muhammad",
 "lastname"  :  "Raza",
 "email"	 :  "razachohan@gmail.com",
 "password"  :  "ABC123ssi",
 "user_type" :  "Sub Admin"
}
```

**Return** __shortened for example purpose__
``` json
{
    "success": true,
    "data": {
        "token": "243e5fb9-15c9-47b4-9b98-de02437d1669",
        "user": {
            "id": 2,
            "firstname": "Muhammad",
            "lastname": "Raza",
            "email": "razachohan@gmail.com",
            "profile_image": null,
            "reset_token": null
        }
    }
}
```
 
