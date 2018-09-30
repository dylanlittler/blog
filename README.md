# A basic blog engine in PHP

This is the code I wrote for my blog. I have copied the code and removed
any specific references and passwords.
The home page will work as is, but the blog page will not work correctly, as the
credentials in connection.php need to be changed to connect to a specific database.
This is only provided here to provide an example of how a blog may be implemented.
The code will not work on another machine without modification, and the changes
needed to adapt this for another blog will be extensive, however the PHP code
should provide some obvious ways to implement the same functions.
As my current blog is not currently accepting users and comments, I moved the code
to make this function into a seperate directory called legacy.
This code can be moved back and included however, and the login functionality
will be available again once a database has been configured.
