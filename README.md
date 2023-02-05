# Filament Custom Field Debugging - Temporary Repo

This temporary repo is for debugging an issue with a Filament custom field.

## Setup

1. git clone
1. configure database connection (SQLite is fine)
1. artisan migrate
1. artisan db:seed
1. artisan make:filament-user
1. Set `.env` values

## Env values

These `.env` values are required:

* SQUARE_APP_ID
* SQUARE_ACCESS_TOKEN
* SQUARE_LOCATION_ID

## Workflow

1. Visit https://site.test/admin/subscriptions
1. Click "Renew" action next to a subscription record
1. Set the renewal price or use what's pre-filled 
1. Select "Credit Card" as payment method
1. Observe Square payment form appearing
1. Use `4111 1111 1111 1111`, any expiration date, CVV `111`, any postal code
1. Click "Charge Credit Card" button, observe "Payment successful" message appear below button
1. Observe the value of the fake payment ID returned from the Square javascript displayed for debugging as the current field state
1. Finally, click "Renew" to attempt to submit the renewal form

## Problems

1. Highest priority: value of custom field state is not included in the $data array that arrives in getAction() in RenewSubscriptionAction when "Renew" is clicked.
```
[2023-02-05 15:32:17] local.DEBUG: Array
(
    [subscriptionId] => 1
    [renewalPrice] => 9
    [paymentMethod] => card
    [squarePayment] =>
)
```

2. Square form components flicker/disappear when other parts of the dom are refreshed or when there's a payment error and the card info has to be filled out twice. Have tried using wire:ignore but this can affect the live updating of the charge dollar amount in what is submitted to Square, which I'd like to preserve as the UI if possible.
3. renewalPrice field does not become disabled as expected when payment method is switched to Credit Card. This is one way I was attempting to deal with DOM refresh issues by being able to set wire:ignore on the "square-payment-wrapper" div and force the user to select a price before selecting the CC payment method, but it is not the ideal UX.

