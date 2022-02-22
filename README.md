# Test Task #

## SetUp ##

- ### Install SymfonyCLI ###

```shell
echo 'deb [trusted=yes] https://repo.symfony.com/apt/ /' | sudo tee /etc/apt/sources.list.d/symfony-cli.list
sudo apt update
sudo apt install symfony-cli
```

- ### Clone project: ###

```shell
git clone git@github.com:alex1rap/php-presentation.git
cd php-presentation
```

- ### Create database ###
- ### Configure environment (in file .env) ###

- ### Migrate: ###

```shell
bin/console doctrine:migrations:migrate
```

- ### Start debug server: ###

```shell
symfony server:start
```

# Routes: #

### Postman collection: ###

```json
{
  "info": {
    "_postman_id": "f1bc8a7b-40df-4b3c-bd2e-8cd79601809b",
    "name": "Presentation",
    "schema": "https://schema.getpostman.com/json/collection/v2.1.0/collection.json"
  },
  "item": [
    {
      "name": "Vehicle",
      "item": [
        {
          "name": "api/vehicle/",
          "request": {
            "method": "POST",
            "header": [],
            "body": {
              "mode": "raw",
              "raw": "{\n    \"type\": \"truck\"\n}",
              "options": {
                "raw": {
                  "language": "json"
                }
              }
            },
            "url": {
              "raw": "127.0.0.1:8000/api/vehicles",
              "host": [
                "127",
                "0",
                "0",
                "1"
              ],
              "port": "8000",
              "path": [
                "api",
                "vehicles"
              ],
              "query": [
                {
                  "key": "offset",
                  "value": "1",
                  "disabled": true
                }
              ]
            }
          },
          "response": []
        },
        {
          "name": "api/vehicle/ (POST)",
          "request": {
            "method": "POST",
            "header": [],
            "body": {
              "mode": "raw",
              "raw": "{\n    \"model\": \"R420\",\n    \"brand\": \"Scania\",\n    \"type\": \"truck\",\n    \"status\": \"sold\",\n    \"price\": 6000000,\n    \"seats\": 0\n}",
              "options": {
                "raw": {
                  "language": "json"
                }
              }
            },
            "url": {
              "raw": "127.0.0.1:8000/api/vehicle/",
              "host": [
                "127",
                "0",
                "0",
                "1"
              ],
              "port": "8000",
              "path": [
                "api",
                "vehicle",
                ""
              ]
            }
          },
          "response": []
        },
        {
          "name": "api/vehicle/{id} (PATCH/PUT)",
          "request": {
            "method": "PATCH",
            "header": [],
            "body": {
              "mode": "raw",
              "raw": "{\n    \"model\": \"R420\",\n    \"brand\": \"Scania\",\n    \"type\": \"truck\",\n    \"status\": \"sold\",\n    \"price\": 6000000,\n    \"seats\": 0,\n    \"pollutionCertificate\": \"A\"\n}\n",
              "options": {
                "raw": {
                  "language": "json"
                }
              }
            },
            "url": {
              "raw": "127.0.0.1:8000/api/vehicle/:id",
              "host": [
                "127",
                "0",
                "0",
                "1"
              ],
              "port": "8000",
              "path": [
                "api",
                "vehicle",
                ":id"
              ],
              "variable": [
                {
                  "key": "id",
                  "value": "2"
                }
              ]
            }
          },
          "response": []
        }
      ]
    }
  ]
}
```
