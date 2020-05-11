# In backend
Run ```sudo mysql <  setup/init.sql``` to create the database

Run ```php vendor/bin/doctrine orm:schema-tool:create ``` to create the schema, resp. "drop" to delete and "update" to update the schema

Serve the public directory with ```php -S localhost:8080 -t public/ ```

Open browser at localhost:8080/api

# In frontend

This is a vue cli project

Run ```npm run serve ```.
Open browser at localhost:3000


