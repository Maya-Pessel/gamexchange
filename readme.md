GamExchange is an online platform dedicated to toy exchange, allowing families to give toys a second life while promoting sharing, reuse, and the circular economy. The goal is to reduce the production of new toys and the amount of waste generated, thereby preserving natural resources and reducing our ecological footprint.

The branding is characterized by vibrant and childlike colors, along with hand-drawn icons, reflecting a joyful and playful atmosphere.

![Branding GamExchange](/assets/images/branding-gamexchange.png "Branding GamExchange")


# Run the project
Get the dependency : `composer require`  
Run the Symfony server : `symfony server:start`  
Run WebpackEncore : `npm run watch`  


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

