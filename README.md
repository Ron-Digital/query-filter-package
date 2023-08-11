# Query Filter and Search

Filter and search in Laravel Model.

```php
composer require rondigital/query-filter
 ```

<br>

The QueryFilter is a trait used for filter, multiple filter and search in Laravel Model. You can install it using the composer command mentioned above. To use it in your class, add the following line with the "use" keyword:


```php
use Rondigital\QueryFilter\QueryFilter;

class YourClass {

use QueryFilter;
// ...
}
```
<br>

Parameters:

- **startingDate** : must be Y-M-D H:i:s 
- **endingDate** : must be Y-M-D H:i:s
- **filteredBy** : must be;
    - *today*
    - *last-24*
    - *last-7-day*
    - *last-30-day*
    - *last-60-day*
    - *last-90-day*
    - *last-year*
    - *this-month*
    - *last-month*
    - *this-week*
    - *last-week*
- **search** : must be search value
    - **searchColumn** : must be column name
- **orderBy** : must be column name
- **orderType** : must be asc/desc

<br>

Inside your function, you can use it as follows:

```php 
$model = Model::all();
return $this->query($model, $request);
```
ex:
```php 
 http://localhost:8000/api/files?search=pdf&searchColumn=extension&filteredBy=today&orderType=asc&orderBy=extension&perPage=1
```
Response / 200 OK
```php
{
    "current_page": 1,
    "data": [
        {
            "id": 6,
            "user_id": 23,
            "filename": "1686910391_siuqkT7MvLsmvpVH",
            "real_filename": "seller-288138-barkod-bazlı-iptal-raporu-2023.05.03-18.17.56.pdf",
            "extension": "pdf",
            "deleted_at": null,
            "created_at": "2023-06-16T10:13:11.000000Z",
            "updated_at": "2023-06-16T10:13:11.000000Z"
        }
    ],
    "first_page_url": "http://localhost:8008/api/files?page=1",
    "from": 1,
    "last_page": 3,
    "last_page_url": "http://localhost:8008/api/files?page=3",
    "links": [
        {
            "url": null,
            "label": "&laquo; Previous",
            "active": false
        },
        {
            "url": "http://localhost:8008/api/files?page=1",
            "label": "1",
            "active": true
        },
        {
            "url": "http://localhost:8008/api/files?page=2",
            "label": "2",
            "active": false
        },
        {
            "url": "http://localhost:8008/api/files?page=3",
            "label": "3",
            "active": false
        },
        {
            "url": "http://localhost:8008/api/files?page=2",
            "label": "Next &raquo;",
            "active": false
        }
    ],
    "next_page_url": "http://localhost:8008/api/files?page=2",
    "path": "http://localhost:8008/api/files",
    "per_page": 1,
    "prev_page_url": null,
    "to": 1,
    "total": 3
}
```
