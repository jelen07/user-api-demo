# User API

## Create User

### Request
`POST /api/v1/createUser`

### Request body

| Parametr name | Description    | Required | Data type
| ------------- | -------------- |:--------:| ---------
| name          | user name      | YES      | string
| email         | user email     | YES      | string
| password      | user password  | YES      | string
| role          | admin or quest | YES      | string

#### Request
```bash
curl -v -N http://localhost:8000/api/v1/createUser \
-X "POST" \
-H "Accept: application/json" \
-H "Content-Type: application/json" \
-d '{
    "name": "Jon Doe",
    "email": "jon.doe@gmail.com",
    "pass": "123456",
    "role": "guest"
}'
```

#### Response
```json
{
    "status": "success",
    "message": "Guest 'Jon Doe' was successfully created."
}
```

## User List

### Request
`GET /api/v1/userListAll` for all users. If you want pagination use `GET /api/v1/userList[/<page>]` 
 
#### Request
```bash
curl -v -N http://localhost:8000/api/v1/userList \
-X "GET" \
-H "Accept: application/json" \
-H "Content-Type: application/json"
```

#### Response
```json
{
    "count": 1,
    "size": 20,
    "users": [
        {
            "id": 1,
            "name": {
                "name": "Jon Doe"
            },
            "email": {
                "email": "jon.doe@gmail.com"
            },
            "password": {
                "password": "$2y$10$rmG7FArBP.teScDgO3T17OPh9hgLrfjPfYIHUwDGtVKwuHdEMhUPm"
            },
            "role": {
                "id": "guest"
            },
            "created": "2018-03-21T02:05:26+01:00",
            "updated": "2018-03-21T02:05:26+01:00"
        }
    ]
}
```
