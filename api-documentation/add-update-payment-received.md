# Add or Update Payment Received

    PUT /api/add-update-payment-received/{orderId?}

## Description
Returns payment received object after storing/updating given payment information

## Request Headers
- **X-Auth-Token** � Authorization Token
- **Content-Type** � application/json


## Parameter
- **OrderId** � Order Id is only required when a particular payment needs to be updated

## Return format
A JSON object containing key **Payment Received**

- **Payment Received**  � Payment Received object


## Example
**Request**

    /api/add-update-payment-received

**Json Body**
```javascript
{
    "uuid"		    : "1c61e74c-5909-4ce2-a0c3-7eda9c2a8ba6",
    "customer_id"   : "1",
    "user_id"	    : "2",
    "order_id"	    : "3",
    "remarks"	    : "Remarks goes here...",
    "payment_type"  : "Cheque",
    "amount"	    : 562.6,
    "promise_cheque_date" : "2017-05-12",
    "cheque_type"	: "Bearer Cheque",
    "cheque_no"		: "wede4redw43432423-234dwdwd"
}
```


**Return** __shortened for example purpose__
``` json
{
    "success": true,
    "message": "Payment Received Created",
    "data": {
        "id": 1,
        "uuid": "1c61e74c-5909-4ce2-a0c3-7eda9c2a8ba6",
        "customer_id": 1,
        "user_id": 1,
        "order_id": 3,
        "remarks": "Remarks goes here...",
        "payment_type": "Cheque",
        "amount": 562.6,
        "promise_cheque_date": "2017-05-12",
        "cheque_type": "Bearer Cheque",
        "cheque_no": "wede4redw43432423-234dwdwd"
    }
}
```

