# EGHL

EGHL is a package to that contain facades to allow integration with EGHL payment gateway . As for now this package only have two method which is to generate query url that use to make a request to eghl and validate payment response . 

## Installation


```bash
composer require killallskywalker/eghl-laravel
```

## Usage

Set the env first . Which is 

```env
EGHL_PASSWORD = your account password
EGHL_SERVICE_ID = your service id
EGHL_SERVICE_URL = your service url 
MERCHANT_RETURN_URL = return url
MERCHANT_APPROVAL_URL = approval url 
MERCHANT_UNAPPROVAL_URL = unapproval url
MERCHANT_CALLBACK_URL = callback url
```

```php
use Eghl;

// For the data , array of parameter require . Can refer to their documentation what is required . 
// To process payment by generating url that will be request to Eghl 
$url = Eghl::processPaymentRequest($data);

// To validate return callback , return true if valid , and otherwise if not valid
$status = Eghl::processPaymentRequest($data);

```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)