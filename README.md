# Coding Challenge For Backend Developer

The challenge is to create a JSON API, which will allow the consumer to search for TV shows by their name, using a simple query string as a GET parameter like so:

https://json-api.local/?q=deadwood

Any other request to the API is invalid and should return the appropriate response.

To get to the data, please use the third party service TVMaze, which provides a convenient API to search for movie titles. Their API description can be found here: http://www.tvmaze.com/api.

Take into account that this third party service has some typo tolerance:

i.e. GET /?q=deadwood would return “Deadpool”, “Redwood Kings”, “Deadwood”...

You should filter these values to be non-case sensitive and non-typo tolerant (only “Deadwood” would be valid).

## Please implement the JSON API, using at least

- PHP 7.x
- Laravel or Lumen
- Git 

## In an optimal case, we would also love to see:

- Optimization of the number of HTTP requests to the third party service (TVMaze)
- Good structure, practices, readability and maintainability
- Tests to verify your code
