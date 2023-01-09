### FEATURES
## Quick todo

* EVENTS




*
* Handle if entered symbol doesnt exist


* Generate a new Code Card

## Main TODO:
* Rework Code Card generation
  * Login to require a code card & password


- Cards - activate/ 'deactivate' cards


* Add a "Forgot Password" feature -> MailHog - DOCKER


* Add an event listener to code card! - Use Events


* address
* personal id
* phone number


  * Balance report should have search options to **filter** and **search**

* Add a contact (?)


#### Later...:
* User has saved contacts
* when doing a transfer, the user can select a contact / someone they sent/received money to/from

* Use Events - clear up Controllers (TransferController)

* Session deletion after inactivity
* Accounts -> adding account u can choose credit/debit = but card or account??

    * Accounts edit modal exit doesnt work
    * Account deletion should have a confirmation

[//]: # (* Currencies - show according symbol in transaction overview)


* Stocks


* Card
  * Card type (i.e. debit, credit, etc.)
  * Card status (i.e. active, inactive, etc.)
  * Card PIN
  * Card limit
  * Card currency
  * Card balance


### TODO:

[//]: # (  * Account type &#40;i.e. savings, checking, credit card, etc.&#41;)
[//]: # (  * Account status &#40;i.e. active, inactive, etc.&#41;)






### DONE:
* Check out the - done -> improved to work without foreach
* "
*         $currencies = Cache::get('currencies');
        foreach ($currencies as $currency) {
            if ($currency['id'] == $account->currency) {
* "

* Currency when buying crypto from an account that is not EUROOOOO - done
* Crypto: fix validation - done

* Transactions need to fix the amount of the transaction
* Add verification to transfers

* Close an account
* Edit account name

* Code Card generation !!!!!!!!!!!!!!!

* Transfers now only save the transaction for user who is sending (fixed)
* Save transaction for recipient (now BOTH in one transaction)
* Decrease money for sender
* Increase money for recipient

* Transfers + verification with Code Card
* Add currency to Transaction

* Do a money transfer

* Code Card

using asset('images/application-logo.png') - gives a white flash on page load - fixed by using a smaller img size

* User has Cards
  * Card name
  * Card nr
  * Card type (i.e. debit, credit, etc.)
  * Card status (i.e. active, inactive, etc.)
  * Card expiry date
  * Card CVV
* Add a new card

* View Transaction history - i.e. account balance report
    * View this for each account -> GET request ?

* User has Accounts
    * Account name
    * Account nr
    * Balance
* Add a new account

* Change Logo
* Overview shows accounts (account name, account nr, balance)
* Change the title
