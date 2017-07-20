# Update Job Order

    PUT /api/update-jobs-order

## Description
Returns success response on order update or error

## Request Headers
- **X-Auth-Token** — Authorization Token

## Example
**Request**

    /api/updaate-jobs-order

**Json Body**
```javascript
[ 
	{ 
		"job_id" : 1,
		"order"  : 4
	},
        {	
    	    "job_id" : 2,
    	    "order"  : 6
        }
]
```

**Return** __shortened for example purpose__
``` json
{
    "success": true,
    "message": "Jobs order Updated"
}
```
 
