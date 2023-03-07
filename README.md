# Slinks

Slinks is a website for organizing personal URLs into categories; something like the bookmark bar but covering a broader customization. Made with Laravel, it allows the user to add links to different sites and put them into "groups" and higher level "blocks", while also providing editing, removing and reordering functionalities for each link, group and block.

## Functional tutorial

### Homepage

![Homepage](/docpics/homepage.png)

Slinks allows you to add _Blocks_, add _Groups_ to _Blocks_ and add _Links_ to _Groups_. As seen in the image, _Blocks_ and _Groups_ are both categories, but with a different scope.

-   _Blocks_ are broad categories.
-   _Groups_ are specific categories.
-   _Links_ are hyperlink text strings that point to a URL and open in a new tab.

This is the intended use of the app, however, anyone can use it differently.

### Add a Block

In order to add a _Block_, click on the big _Plus_ icon next to the _Active Blocks_ text.

![Click on the big Plus icon next to Active Blocks to add a Block](/docpics/addblock.png)

You will be asked to insert a name.

![Insert the name of your Block](/docpics/addblock2.png)

Once you have named your block, click the _Add_ button and your _Block_ will now be added to the _Active Blocks_ section.

![New block has been added](/docpics/addblock3.png)

### Edit/Archive a Block

In order to edit a _Block_, click on the small _Notepad_ icon on the right of it.

![Click on the small Notepad icon on the right of the Block to edit it](/docpics/editblock.png)

Inside the edit page you can change the name of the Block and/or Archive it.

![You can change the name of a Block or archive it](/docpics/editblock2.png)

When done, click on the _Edit_ button and your _Block_ will be updated in the Homepage.

![The Block will be updated in the Homepage](/docpics/editblock3.png)

Once a _Block_ has been archived its contents can no longer be edited until the _Block_ is unarchived.

### Delete a Block

In order to delete a _Block_, click on the small _Trash Can_ icon on the right of it.

![Click on the small Trash Can icon on the right of the Block to delete it](/docpics/deleteblock.png)

Before deleting the _Block_, Slinks will ask you if you are sure you want to perform that action with a confirmation box.

![Confirmation box to delete a Block](/docpics/deleteblock2.png)

## Add a Group

Adding a _Group_ is as easy as clickin on the small _Plus_ icon on the right of a _Block_.

![Click on the small Plus icon on the right of a Block to create a Group for it](/docpics/addgroup.png)

You can only name the _Group_ when creating it, since Slinks will know what _Block_ you want it added to.

![Name the Group](/docpics/addgroup2.png)

Once done, click on the _Add_ button and the _Block_ will be updated with the new _Group_.

![Group added](/docpics/addgroup3.png)

## Technical overview

Server-side rendered Laravel project connected to a RDBMS with JQuery as a helper library.

### Tech stack

-   FRONTEND: Blade Templates.
-   BACKEND: Laravel Framework.
-   DBMS: PostgreSQL.
-   JS Libraries: JQuery.

## For devs

### How to: set up

-   Set up the `.env` file by using the `.env.template` file and asking the person in charge the secret variables' values.
-   Install dependencies with `composer install`.
-   Migrate the database with `php artisan migrate`.
-   Serve the app locally with `php artisan serve`.

### How to: deploy

-   Checkout either the `staging` or `master` branch for the staging or production environments respectively.
-   Push your changes to the current branch.
-   Changes will be automatically deployed respective remote environment using CI/CD.
