# In backend

Install dependencies with composer

Run ```sudo mysql <  setup/init.sql``` to create the database

Run ```php vendor/bin/doctrine orm:schema-tool:create ``` to create the schema, resp. "drop" to delete and "update" to update the schema

Run the tests ``` php vendor/bin/phpunit tests/ ```

Serve the public directory with ```php -S localhost:8888 -t public/ ```

Open browser at localhost:8888/api

### Attention!:
Make public/uploads directory writable with 
```
chmod -R 777 public/uploads
```
Set post_max_size = 20M and upload_max_filesize = 20M and max_file_uploads = 15 in php.ini for example

# In frontend

Install dependencies with npm

This is a vue cli project

Run ```npm run serve ```.
Open browser at localhost:8080


## Postman

Import the following json into postman to see the fileuplod in action:

```
{
	"info": {
		"_postman_id": "d6c4afb3-2a46-47f6-bd3e-6c69552edde2",
		"name": "treemap",
		"schema": "https://schema.getpostman.com/json/collection/v2.1.0/collection.json"
	},
	"item": [
		{
			"name": "post files",
			"request": {
				"method": "POST",
				"header": [
					{
						"key": "Accept",
						"value": "application/json",
						"type": "text"
					},
					{
						"key": "x-project-title",
						"value": "dd",
						"type": "text"
					}
				],
				"body": {
					"mode": "formdata",
					"formdata": [
						{
							"key": "files[]",
							"contentType": "multipart/form-data",
							"type": "file",
							"src": [
								"/home/sili/java_error_in_IDEA_27935.log",
								"/home/sili/stale_outputs_checked"
							]
						},
						{
							"key": "x-project-title",
							"value": "\"dd\"",
							"type": "text",
							"disabled": true
						}
					]
				},
				"url": {
					"raw": "localhost:8888/api/projects",
					"host": [
						"localhost"
					],
					"port": "8888",
					"path": [
						"api",
						"projects"
					]
				}
			},
			"response": []
		}
	],
	"protocolProfileBehavior": {}
}
```


