# MintWise - Internet Bank (+ Crypto trading) 

## Table of contents

* [General info](#general-info)
* [Demonstration GIFs](#demonstration-gifs)
* [Used Technologies](#used-technologies)
* [Setup](#setup)

## General info

This project is a internet bank where one can:

* Open bank accounts
* Make money transfers
* Buy & sell cryptocurrencies
* View asset portfolio

Information about coins can be retrieved using dummy data or real data from an <ins>**API**</ins> (set up for using the
CoinMarketCap API)

## Demonstration GIFs

<div style="text-align: center">
    <h3>Overall overview</h3>
    <p align="center">
        <img src="/overview-.gif"  width="95%" alt="animated-demo" /><br>
    </p>
    <h3>Making a transaction (to an account that has a different currency)</h3>
    <p align="center">
        <img src="/transaction-eur-gbp.gif" width="95%" alt="animated-demo" /><br>
    </p>
    <h3>Search in transactions</h3>
    <p align="center">
        <img src="/search-transactions.gif" width="95%" alt="animated-demo" /><br>
    </p>
    <h3>Purchasing Crypto</h3>
    <p align="center">
        <img src="/crypto-purchase.gif" width="95%" alt="animated-demo" /><br>
    </p>
</div>

## Used Technologies

* Laravel `9.45`
* PHP `8.0`
* MySQL `8.0`
* Composer `2.4`

Style:
* TailwindCSS

## Setup

To install this project on your local machine, follow these steps:

##### Getting the workplace ready
1. Clone this repository - `git clone https://github.com/guztus/MintWise_Bank`
2. Locate "/public"
3. Install composer dependencies - `composer install`
4. Install node dependencies - `npm install`
6. Rename the ".env.example" file to ".env" <br>
7. Create a database and add the credentials to the ".env" file
8. Register on <a href="https://coinmarketcap.com/api/">CoinMarketCap</a> (it's free!) for an API key and enter it in the ".env" file
##### Running the project
9. Generate your key for the project `php artisan key:generate`
10. To run the project, enter `php artisan serve` (to run the backend) and `npm run dev` (to run the frontend).
11. Make a dummy account `php artisan db:seed --class=BaseAccountSeeder` 

(Dummy account login details - email: user@user.lv, password: password, codes: 1;2;3;4;5;6;7;8;9;10;11;12)
