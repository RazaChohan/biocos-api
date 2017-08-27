# Add or Update Payment Received

    PUT /api/add-update-payment-received

## Description
Returns payment received array after storing/updating given payment information

## Request Headers
- **X-Auth-Token** � Authorization Token
- **Content-Type** � application/json

## Return format
A JSON object containing key **Payment Received**

- **Payment Received**  � Payment Received object


## Example
**Request**

    /api/add-update-payment-received

**Json Body**
```javascript
[
	{
		"uuid"		    : "1c61e74c-5909-4ce2-a0c3-7eda9c2a8ba6",
		"customer_id"   : "1",
		"user_id"	    : "2",
		"order_id"	    : "3",
		"remarks"	    : "Remarks goes here...",
		"payment_type"  : "Cheque",
		"amount"	    : 562.6,
		"is_success"    : true,
	    "promise_cheque_date" : "2017-05-12",
		"cheque_type"	: "Bearer Cheque",
		"cheque_no"		: "wede4redw43432423-234dwdwd"
	},
	{
		"uuid"		    : "1c61e74c-5909-4ce2-a0c3-7eda9c2a8ba3",
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
]
```


**Return** __shortened for example purpose__
``` json
{
    "success": true,
    "message": "Payment Received Updated/Created",
    "data": [
        {
            "id": 8,
            "uuid": "1c61e74c-5909-4ce2-a0c3-7eda9c2a8ba6",
            "customer_id": 1,
            "user_id": 1,
            "remarks": "Remarks goes here...",
            "payment_type": "Cheque",
            "amount": 562.6,
            "promise_cheque_date": "2017-05-12",
            "cheque_type": "Bearer Cheque",
            "cheque_no": "wede4redw43432423-234dwdwd",
            "is_success": 1
        },
        {
            "id": 9,
            "uuid": "1c61e74c-5909-4ce2-a0c3-7eda9c2a8ba3",
            "customer_id": 1,
            "user_id": 1,
            "remarks": "Remarks goes here...",
            "payment_type": "Cheque",
            "amount": 562.6,
            "promise_cheque_date": "2017-05-12",
            "cheque_type": "Bearer Cheque",
            "cheque_no": "wede4redw43432423-234dwdwd",
            "is_success": 0
        }
    ]
}
```

