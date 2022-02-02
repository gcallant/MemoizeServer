Memoize
=============

What is Memoize?
----------------

_Memoization_ was a word coined by Donald Michie in 1968 as a command to a computer to _"take a memo"_ [[1]](https://www.cs.utexas.edu/users/hunt/research/hash-cons/hash-cons-papers/michie-memo-nature-1968.pdf).

In this context, Memoize is an application designed to securely authenticate users on websites _without passwords_ **and** provide _Two Factor Authentication_ protection.


How do I use it?
-----------------

If you are a user, ask your system administrator or webmaster to do one of two things:

* Install this application on your organization's backend server and privately store and host information. 
* They will also need to use the API to plug in to your organization's website to allow login.

* Use the included default API in your organization's website and use our servers to store and host information.

If you are a system administrator, webmaster, or enthusiastic user:

Dependencies
----------------------------
This project requires Node.JS >= 15.6.0, npm >= 7.4.0, and PHP >= 7.3.1, as well as the companion 
MemoizeiOS project companion application in order to demonstration full authentication capabilities.

Installation
----------------------------
First clone this repository, and in terminal run npm install. This will download
and install all front-end dependencies. Then run npm run dev. This will set up and 
scaffold all the project JS and CSS assets. You will need to create a .env file
(as demonstrated using the .env.example file provided) with a working database. 
Then you can simply run php artisan serve, and it will start a local server on 
http://localhost:8000. To login, you will need to scan the QR Code with your iOS device
using the MemoizeiOS companion application.


Troubleshooting
---------------

Open an issue in this repository.
