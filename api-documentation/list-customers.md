# List Customers

    GET /api/list-customers

## Description
Returns list of customers depending upon the parameters/filters passed

## Headers
- **X-Auth-Token** — Authorization token of user


## Parameters
- **user_id** — user id of user for which customer needs to be fetched (If this parameter is not passed user id will be used from X-Auth-Token)
- **region_id** — region Id for which customer needs to be fetched,
- **sub_region** — sub region (true/false) fetch jobs for sub regions as well,


## Return format
A collection JSON objects containing keys **customers**

- **Customer** — Customer object


## Example
**Request**

    /api/list-customer?user_id=1&region_id=1sub_region=true

**Return** __shortened for example purpose__
``` json
{
    "success": true,
    "message": "Customers found",
    "data": [
        {
            "id": 1,
            "agency_id": null,
            "name": "Haji Pan Shop",
            "proprietor_id": 1,
            "contact_person_id": 1,
            "location": "Lahore",
            "latitude": 22.3,
            "longitude": 33.2,
            "phone_1": "5465465",
            "phone_2": "4564654",
            "email": "razachohan@gmail.com",
            "type": "wholesaler",
            "industry": "Super store",
            "discount percentage": "wholesaler",
            "biocos_ratting": 0.5,
            "region_id": 1,
            "status": "approved",
            "Category": "A+",
            "created_by": 1,
            "updated_by": 1,
            "deleted_by": 1,
            "created_at": "2017-06-19 00:03:38",
            "updated_at": "2017-06-19 00:03:40",
            "deleted_at": null,
            "images": [
                {
                    "id": 1,
                    "image": "tet.jpg",
                    "shop_id": 1
                }
            ]
        }
    ]
}
```
