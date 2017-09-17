# Update order status

    POST /api/update-order-status

## Description
Update status of order by passing order id in body 

## Request Headers
- **X-Auth-Token** Authorization Token
- **Content-Type** application/json

## Example
**Request**

    /api/update-order-status

**Json Body**
```javascript
{
	"order_id" : 2,
	"status":    'Rejected' 
}
```

**Return** __shortened for example purpose__
``` json
{
    "success": true,
    "message": "Order Status Updated!!"
}
```
**Possible Status Values**
 
 - Rejected
 - Booked
 - Confirmed
 - Processed
 - Ready
 - Delivered
 - Cleared
 - Rejected
 - Cancelled
