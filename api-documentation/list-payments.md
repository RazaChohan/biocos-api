# List Payments

    GET /api/list-payments

## Description
Returns list of payments depending upon the parameters/filters passed

## Headers
- **X-Auth-Token** — Authorization token of user


## Parameters
- **customer_id** — customer id of customer for which customer needs to be fetched
- **page** — Page number for pagination


## Return format
A collection JSON objects containing keys **payments**

- **Payment Received** — Payment Received object


## Example
**Request**

    /api/list-customer-payments?customer_id=1&page=1

**Return** __shortened for example purpose__
``` json
{
    "success": true,
    "message": "Payments found",
    "data": [
        {
            "id": 17,
            "uuid": "1c61e74c-5909-4ce2-a0c3-7eda9c2a8ba6",
            "customer_id": 4,
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
            "id": 19,
            "uuid": "1c61e74c-5909-4ce2-a0c3-7eda9c2a8ba6",
            "customer_id": 4,
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
            "id": 21,
            "uuid": "1c61e74c-5909-4ce2-a0c3-7eda9c2a8ba6",
            "customer_id": 4,
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
            "id": 23,
            "uuid": "1c61e74c-5909-4ce2-a0c3-7eda9c2a8ba6",
            "customer_id": 4,
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
            "id": 25,
            "uuid": "1c61e74c-5909-4ce2-a0c3-7eda9c2a8ba6",
            "customer_id": 4,
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
            "id": 27,
            "uuid": "1c61e74c-5909-4ce2-a0c3-7eda9c2a8ba6",
            "customer_id": 4,
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
            "id": 29,
            "uuid": "1c61e74c-5909-4ce2-a0c3-7eda9c2a8ba6",
            "customer_id": 4,
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
            "id": 31,
            "uuid": "1c61e74c-5909-4ce2-a0c3-7eda9c2a8ba6",
            "customer_id": 4,
            "user_id": 1,
            "remarks": "Remarks goes here...",
            "payment_type": "Cheque",
            "amount": 562.6,
            "promise_cheque_date": "2017-05-12",
            "cheque_type": "Bearer Cheque",
            "cheque_no": "wede4redw43432423-234dwdwd",
            "is_success": 1
        }
    ]
}
```
