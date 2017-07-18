# GraphQL Client

A simple package to consume GraphQL APIs.

-----------------------


## Installation

`composer require euautomation/graphql-client`

-----------------------


## Usage

Create an instance of `EUAutomation\GraphQL\Client`:

```
new Client($graphQLURL);
```

or 

```
$client = new Client();
$client->setUrl($graphQLURL);
```

-----------------------


## Response class

Pass in your query, optional variables and headers (eg bearer token), `$variables` and `$headers` are optional

`$response = $client->response($query, $variables, $headers);`

### all()

Use `$response->all();` to get all of the data returned in the response

### errors()

Use `$response->errors();` to get all the errors returned in the response

### hasErrors()

Use `$response->hasErrors();` to check if the response contains any errors

### Specific data from the response class

For example purposes, let's assume you want to get a list of all categories and execute this query.

```
{
    allCategories(first:10) {
        category {
            id,
            name,
            slug,
            description
        }
    }
}
```

Now in order to fetch some meaningful data from the Response class you can do the following:

```
$categories = $response->allCategories->category;

foreach($categories as $category) {
    // Do something with the data?
    $category->id;
    $category->name;
    $category->slug;
    $category->description;
}
```

You can also set, unset or isset data on the Response class.

-----------------------


## Other responses

### Raw guzzle response

Pass in your query, optional variables and headers (eg bearer token), `$variables` and `$headers` are optional

`$client->raw($query, $variables, $headers);`

### Json

Pass in your query, optional variables and headers (eg bearer token), `$variables` and `$headers` are optional

`$client->json($query, $variables, $headers);`
