# Slinks

Slinks is a website for organizing personal URLs into categories; something like the bookmark bar but covering a broader customization. Made with Laravel, it allows the user to add links to different sites and put them into "groups" and higher level "blocks", while also providing editing, removing and reordering functionalities for each link, group and block.

## Functional overview

TODO: Functional overview

## DEV ONLY

### How to: set up

-   Set up the `.env` file by using the `.env.template` file and asking the person in charge the secret variables' values.
-   Install dependencies with `composer install`.
-   Migrate the database with `php artisan migrate`.
-   Serve the app locally with `php artisan serve`.

### How to: deploy

-   Checkout either the `staging` or `master` branch for the staging or production environments respectively.
-   Push your changes to the current branch.
-   Changes will be automatically deployed respective remote environment using CI/CD.
