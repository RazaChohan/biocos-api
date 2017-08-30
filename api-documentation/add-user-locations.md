# Add User locations

    PUT /api/add-user-locations

## Description
Returns success messages

## Request Headers
- **X-Auth-Token** — Authorization Token

## Example
**Request**

    /api/add-user-locations

**Json Body**
```javascript
[ 
	{ 
		"latitude"  : 25.5,
		"longitude" : 22.2,
		"date"	    : "2017-08-15 12:34"
	},
    {	
    	"longitude" : 85.6,
    	"latitude"  : 74.6,
    	"date"      : "2017-07-14 23:10"
    }
]
```

**Return** __shortened for example purpose__
``` json
{
    "success": true,
    "message": "Location updated"
}
```