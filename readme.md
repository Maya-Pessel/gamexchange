# Route

Home : `/`  
Login : `/login`  
Login : `/register`  

## Product
Create a product : `/create`   
Show a product by id : `/product/{id<[0-9]+>}`  
Edit a product by id : `/product/{id<[0-9]+>}/edit`  
Delete a product by id : `/product/{id<[0-9]+>}/delete`  

## User
See a profile by id : `/user/{id<[0-9]+>}`  
Edit your profile  : `/user/{id}/update`  


## Exchange
Exchange page : `/product/{id<[0-9]+>}/exchange`  


# Run the project
Get the dependency : `composer require`  
Run the Symfony server : `symfony server:start`  
Run WebpackEncore : `npm run watch`  
