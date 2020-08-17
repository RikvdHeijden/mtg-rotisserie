# Rotisserie Draft Tool

This tool allows you to host your own multiplayer rotisserie drafts.
After drafting a deck you can export it to Magic Arena and play with your friends.

This tool is based on a very basic Laravel installation and hacked together
in the course of a few short evenings. So don't expect high quality code
or well thought out solutions. 

I've included a .lando.yml (https://lando.dev/) file so you can quickly get started with a local
development environment.

## Setup
Follow the basic instructions for setting up a Laravel server, or use the included
Lando file to set up a compatible server by running lando start.

This app uses pusher to ensure interactivity, so make sure you configure that in the .env file.

After running composer install run artisan migrate to setup the database.

Finally you should only have to run `` artisan import:set <set code> --booster-only``
to import a set from scryfall into the database. For some sets (specifically Amonkhet remastered) 
you should always emit the --booster-only flag.



