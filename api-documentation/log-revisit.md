# Log revisit

    POST /api/log-revisit

## Description
Returns object of newly created job

## Headers
- **X-Auth-Token** — Authorization token of user


## Return format
A JSON object containing key **data**

- **Data** — Job object


## Example
**Request**

    /api/log-revisit

**Return** __shortened for example purpose__
``` json
{
	"customer_id": 1,
	"date"       : "05-09-2019",
	"latitude"	 : 20.55,
	"longitude"  : 105.55,
	"region_id"  : 2,
	"time"		 : "15:12",
	"uuid"		 : "sdfsd234dssdvdvdfvdsvd",
	"completed_on" : "05-10-2020",
   "images:     : [],
    "remove_images" : [] # in order to remove images

}
```


**Return** __shortened for example purpose__
``` json
{
    "success": true,
    "message": "Revisit job added",
    "data": {
        "id": 15,
        "agency_id": null,
        "region_id": 2,
        "date": "2019-09-05 00:00:00",
        "customer_id": 1,
        "user_id": 1,
        "status": "Completed",
        "completed_on": "2020-10-05 00:00:00",
        "employee_location": "",
        "visit_type": null,
        "comment": "revisit",
        "order": 0,
        "created_by": 1,
        "updated_by": 1,
        "deleted_by": null,
        "created_at": "2017-09-17 19:39:28",
        "updated_at": "2017-09-17 19:39:28",
        "deleted_at": null,
        "uuid": "sdfsd234dssdvdvdfvdsvd",
        "longitude": 105.55,
        "latitude": 20.55,
        "reason": null,
        "time": "15:12:00"
    }
}
```