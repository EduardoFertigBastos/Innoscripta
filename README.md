# Innoscripta 
## Full Stack Web Developer

To clone the repository, you can access the link and install via Github Desktop, or using the git clone command in the terminal.

        git clone https://github.com/EduardoFertigBastos/Innoscripta.git

And in the root of the folder (which contains web folder, server folder and docker-compose.yml), just run docker compose through the terminal to initialize the database, backend and frontend.

        docker compose up --build
        
And it's done. Both backend and frontend will be initialized.

The web folder has the react app and the server has the laravel app.

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
        
        
## Front-End
The frontend listens on port 80. The frontend application contains three pages.
The first page is the login page, where the user can login.

        localhost:80

The second page is the registration page where the user can register in the application by registering a name, email and password. 

        localhost:80/sign-up

The third page is the dashboard which contains several cards from all the articles in the database. 
For performance reasons, the articles are paged, with 12 articles being loaded per page.  
It is possible to filter all results by keywords, category, source and date (all articles posted after that date) [Filter 1].  
It is also possible to customize the user's feed by clicking on the "customize" button, which opens a modal where the user can select 3 favorite authors, 3 favorite categories and 3 favorite sources [Filter 2].  
After saving, all articles listed by Filter 1 must obey Filter 1 and also Filter 2.  
The application also has a menu where it allows the user to logout.

        localhost:80/dashboard

The entire application was developed with the purpose of offering a beautiful responsive interface that caters to all users, from those using computers to those using mobile devices.
