# In backend
Run ```sudo mysql <  setup/init.sql``` to create the database

Run ```php vendor/bin/doctrine orm:schema-tool:create ``` to create the schema, resp. "drop" to delete and "update" to update the schema

Run the tests ``` php vendor/bin/phpunit tests/ ```

Serve the public directory with ```php -S localhost:8888 -t public/ ```

Open browser at localhost:8888/api

### Attention!:

Set post_max_size = 20M and upload_max_filesize = 20M and max_file_uploads = 15 in php.ini for example

# In frontend

This is a vue cli project

Run ```npm run serve ```.
Open browser at localhost:3000


