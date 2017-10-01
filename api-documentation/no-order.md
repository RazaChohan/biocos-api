# Log no order

    POST /api/log-no-order

## Description
Returns object of newly created job

## Headers
- **X-Auth-Token** — Authorization token of user


## Return format
A JSON object containing key **data**

- **Data** — Job object


## Example
**Request**

    /api/log-no-order

**Return** __shortened for example purpose__
``` json
{
	"customer_id": 1,
	"date"       : "05-09-2019",
	"latitude"	 : 20.55,
	"longitude"  : 105.55,
	"reason"     : "Reason goes here",
	"region_id"  : 2,
	"remarks"    : "Remarks goes here...",
	"time"		 : "15:12",
	"uuid"		 : "sdfsd234dssdvdvdfvdsvd",
	"images:     : [],
	"remove_images" : [] # in order to remove images
}
```


**Return** __shortened for example purpose__
``` json
{
    "success": true,
    "message": "No order job added",
    "data": {
        "id": 13,
        "agency_id": null,
        "region_id": 2,
        "date": "2019-09-05 00:00:00",
        "customer_id": 1,
        "user_id": 1,
        "status": "Completed",
        "completed_on": "2019-09-05 00:00:00",
        "employee_location": "",
        "visit_type": null,
        "comment": "Remarks goes here...",
        "order": 0,
        "created_by": 1,
        "updated_by": 1,
        "deleted_by": null,
        "created_at": "2017-09-17 19:00:57",
        "updated_at": "2017-09-17 19:00:57",
        "deleted_at": null,
        "uuid": "sdfsd234dssdvdvdfvdsvd",
        "longitude": 105.55,
        "latitude": 20.55,
        "reason": "Reason goes here",
        "time": "15:12:00"
    }
}
```