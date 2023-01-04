### FEATURES
## Quick todo
* Add verification to transfers

* Generate a new Code Card

## Main TODO:
* Rework Code Card generation
  * Login to require a code card & password


* Close an account
* Edit account name
- Same for Cards - activate/ 'deactivate' cards


## Secondary TODO:
* Add a "Forgot Password" feature -> MailHog - DOCKER


#### **On registration**
* Add an event listener to code card! - Use Events


#### User has:
* address
* personal id
* phone number


#### Options to:
  * Balance report should have search options to **filter** and **search**

* Add a contact (?)


#### Later...:
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
