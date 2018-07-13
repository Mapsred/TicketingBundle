TicketingBundle
=====


### What is it ?

The objective of this TicketingBundle is to implement a ticketing interface in your website.
Similarly to Bundles like FosUserBundle or FosCommentBundle, this bundle helps to create features. 


### Who can use it ?

Everyone can use it but I recommend it for small / medium community who wants to propose a support service 
because of the simple workflow in place.
I think that support with tickets is an easier way to make a support application instead of chat because it has a 
better structure. 

### How does it work ?

You can implement this bundle swiftly thanks to the recipe for Symfony 3.4 / 4.* 

All you need is to have a User security system in your application and a DataBase to stock the informations.

### What is the workflow ?

The workflow is as following :

A User have a problem and wants an answer, he goes to the website to open a ticket.
In this ticket he will be able to write a description, choose a priority (urgent, low, ...), 
a category (question, bug, suggestion) and as a bonus, he will be able to reference other tickets who could be 
linked to the actual problem.

Once the user created his ticket, he will have to wait for other users or staff member to answer it.

Once it is done and he is satisfied with the answer. He will be able to close it or answer it back.
Now that the ticket is closed, our user, the author, will be able to give a notation from 1 to 5 
corresponding to his satisfaction during the help in the ticket.


[return to the index](../README.md)