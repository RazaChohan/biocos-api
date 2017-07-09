# Get Customer Details

    GET /api/customer-details/{ID}

## Description
Returns object of customer depending upon the ID of customer passed as parameters

## Headers
- **X-Auth-Token** — Authorization token of user


## Parameters
- **Customer Id** — ID of customer for which details are required


## Return format
A JSON object containing key **data**

- **Data** — Customer object


## Example
**Request**

    /api/customer-details/1

**Return** __shortened for example purpose__
``` json
# Get Order Details

    GET /api/order-details/{ID}

## Description
Returns object of order depending upon the ID of order passed as parameters

## Headers
- **X-Auth-Token** — Authorization token of user


## Parameters
- **Order Id** — ID of order for which details are required


## Return format
A JSON object containing key **data**

- **Data** — Order object


## Example
**Request**

    /api/order-details/1

**Return** __shortened for example purpose__
``` json
{
    "success": true,
    "message": "Customer found",
    "data": {
        "id": 4,
        "agency_id": null,
        "name": "Wood works",
        "proprietor_id": 1,
        "contact_person_id": 12,
        "location": "Liberty Market Lahore",
        "latitude": 31.577986,
        "longitude": 74.317994,
        "phone_1": "456456-56465-54",
        "phone_2": "55645-456645-44",
        "email": "admin@biocospk.com",
        "type": "wholesaler",
        "industry": "Super store",
        "discount_percentage": "retail saler",
        "biocos_ratting": 21.3,
        "region_id": 1,
        "status": "rejected",
        "Category": "D",
        "created_by": 1,
        "updated_by": 1,
        "deleted_by": 0,
        "created_at": "2017-07-09 20:58:14",
        "updated_at": "2017-07-09 20:59:13",
        "deleted_at": null
    }
}

```
