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

* PHP `8.0`
* MySQL `8.0`
* Composer `2.4`

Style:
* TailwindCSS

## Setup

To install this project on your local machine, follow these steps:

1. Clone this repository - `git clone https://github.com/guztus/MintWise_Bank`
2. Install all dependencies - `composer install`
3. Rename the ".env.example" file to ".env" <br>
4. Create a database and add the credentials to the ".env" file
5. Make a dummy account `php artisan db:seed --class=BaseAccountSeeder` 

(Login details - email: user@user.lv, password: password, codes: 1;2;3;4;5;6;7;8;9;10;11;12)

* In order for the Crypto section to wrok, you will need to enter your own CoinMarketCap API key in the ".env" file.<br>

To run the project, locate "/public" and there, you can use a command such as `php artisan serve` (to run the backend) and `npm run dev` (to run the frontend).
