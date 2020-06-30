# WordPress Shared workflow

All WordPress websites consist of Database and Files. In order to work in a shared workflow, all team members will need to keep both in sync. We do that by using a plugin and Git, and deploy to a remote hosting accessible by everyone.

## Setting up

Make sure to install Git on your computer. If you prefer, you can also install a visual Git client like Fork.

You will also need an HTTP server with PHP and MySQL running on your machine - I recommend using XAMP or MAMP depending on your operational system.


### Getting the files for the first time

After installing git on your machine, go ahead and run the following command from the terminal to clone the git repository (don't forget to change the directory to your public local server folder - e.g. "htdocs".)

```bash
git clone https://github.com/digelim/joshbersin.git
```

### Getting the database

Now that you have the files copied to your computer, you'll need to set up WordPress for the first time. I recommend using a tool like phpMyAdmin to create a new empty database for this site.

After you connect WordPress with the database, make sure to enable the database synchronization plugin. We are going to use the WP Sync DB, which is free.

To fetch the database from the remote server for the first time, go to Tools > Migrate DB, select ```Pull``` and use the settings below:

```html
https://joshbersin.naubly.com
hZb2a7JyGJQru4y+1q1D1l8FzbupO1Cz
```


## Synchronizing

Now that you fetched the database and files for the first time, you are all set to start programming. But after that, you will need to make sure that you are in sync between all developers and the remote website, before and after doing your work. So follow the instructions below.

### Synchronizing the files

#### Before starting

```bash
git pull --progress -v --no-rebase origin master
```

#### After finishing
```bash
git add .
git commit -am "Some commit description"
git push -u origin master
```

### Synchronizing the database

Go to ```Tools > Migrate DB```

#### Before starting

1. Select ```Pull```
2. Enter the connection settings above

#### After finishing

1. Select ```Push```
2. Enter the connection settings above

## Contributing
Questions? email me at diogoangelim@gmail.com or Slack me
