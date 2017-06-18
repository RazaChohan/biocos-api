# List Jobs

    GET /api/list-jobs

## Description
Returns list of jobs depending upon the parameters/filters passed

## Headers
- **X-Auth-Token** — Authorization token of user


## Parameters
- **user_id** — user id of user for which jobs needs to be fetched (If this parameter is not passed user id will be used from X-Auth-Token)
- **region_id** — region Id for which jobs needs to be fetched,
- **date** — date for which jobs needs to be fetched,
- **status** — status (Pending,Completed,Postponed),
- **sub_region** — sub region (true/false) fetch jobs for sub regions as well,


## Return format
A collection JSON objects containing keys **jobs**

- **Job** — Job object


## Example
**Request**

    /api/list-jobs?user_id=1&region_id=1&date=2017-06-12&status=Pending&sub_region=true

**Return** __shortened for example purpose__
``` json
{
    "success": false,
    "message": "Jobs found",
    "data": [
        {
            "id": 3,
            "agency_id": null,
            "region_id": 3,
            "date": "2017-06-12 00:00:00",
            "customer_id": 11,
            "user_id": 1,
            "status": "Pending",
            "completed_on": "2017-06-27 00:00:00",
            "employee_location": "",
            "visit_type": "Visit",
            "comment": "`",
            "order": 0,
            "created_by": 0,
            "updated_by": 0,
            "deleted_by": 0,
            "created_at": "2017-06-13 19:00:00",
            "updated_at": "2017-06-04 19:00:00",
            "deleted_at": null
        }
    ]
}
```
