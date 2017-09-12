# Cancel order

    POST /api/cancel-order

## Description
Cancel order by passing order id in body 

## Request Headers
- **X-Auth-Token** Authorization Token
- **Content-Type** application/json

## Example
**Request**

    /api/cancel-order

**Json Body**
```javascript
{
	"order_id" : 2 
}
```

**Return** __shortened for example purpose__
``` json
{
    "success": true,
    "message": "Order Cancelled"
}
```
 
