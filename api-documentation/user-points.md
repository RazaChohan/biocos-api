# Get User Points

    GET /user-points?{user_id=user_id}&{start_date=start_date}&{end_date=end_date} 
    - User Id is optional, Start date and end date are optional

## Description
Returns user object with regions

## Parameters
- **user_id** — User id
- **start_date** - Start Date
- **end_Date** - End Date

## Return format
A JSON object containing keys **data**

- **Date**      —  User points


## Examples
**Request**

  - user-points?user_id=1&start_date=2017-10-07&end_date=2017-10-08 (User id is optional if not provided user 
                                   ID from auth token will be used)
  - user-points?user_id=1
  - user-points?user_id=1&start_date=2017-10-07
  user-points?user_id=1&end_date=2017-10-08                                 

**Return** __shortened for example purpose__
``` json
{
    "success": true,
    "message": "User points",
    "data": "4"
}
```
