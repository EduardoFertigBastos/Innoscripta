## Back-end
The backend listens on port 8000 and had its articles loaded with the NewsAPI.org, The Guardian and New York Times APIs. The application has 8 routes that are used.


### Unauthenticated routes
The first is the login route where the user must authenticate using an email and password. If the login is successful, the user receives a Json Web Token with a duration of 60 minutes.

        [POST] localhost:8000/api/login

The second route is the route for user registration, where the user needs a password, an email (which must be unique), and a password that must have 8 characters, an uppercase letter, a lowercase letter and the password must be confirmed through the 'password_confirmation' field.

        [POST] localhost:8000/api/users

### Authenticated routes
All routes listed below require authentication.


The article route lists the existing articles in the system with pagination. Can take the following parameters.
  
  [Pagination]
    -page - Current page (default 1).  
    -per_page - How many records to load per page (default 20).  

  [Filter 1]
    -keyword - Filter keyword by article title or description.  
    -category - Filter by article category.  
    -source - Filter by article source.  
    -from - Filters all articles posted after the mentioned date (format yyyy-mm-dd).  

  [Filter 2] - Customization
    -fav_authors[] - You can receive up to 3 favorite authors.  
    -fav_categories[] - Can receive up to 3 favorite categories.  
    -fav_sources[] - Can receive up to 3 favorite sources.  

        [GET] localhost:8000/api/articles
        
Lists all existing authors in the database.
Returns a message (message) and an array (data) containing the names of all authors.
    
        [GET] localhost:8000/api/articles/authors
    
Lists all existing fonts in the database.
Returns a message (message) and an array (data) containing the names of all sources.

        [GET] localhost:8000/api/articles/sources

Lists all existing categories in the database.
Returns a message (message) and an array (data) containing the names of all categories.

        [GET] localhost:8000/api/articles/categories

List user configuration (user identified by token)
Returns a message (message) and settings (settings), which is an object with the attributes fav_categories (array), fav_sources (array), fav_authors (array)

        [GET] localhost:8000/api/user-config

Update user configuration (user identified by token)
It can take three parameters. fav_categories (array), fav_sources (array), fav_authors (array)

        [PATCH] localhost:8000/api/articles/user-config
        
        