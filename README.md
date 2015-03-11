# NeatStuff

This is a reference application which demonstrates usage of a few of Weebly's Cloud for Host APIs.
NeatStuff was written during an internal hackathon in late December 2014 by...
 * Drew Richards <drew@weebly.com>
 * Dustin Doiron <dustin@weebly.com>

The concept behind this was see if it was possible to, effectively, write a moderately-featured webhost in 24 hours. (It was)

To see NeatStuff in action, you can visit http://store.neatstuffontheinternet.com.

# Requirements
 * PHP >= 5.6
 * PostgreSQL

# Getting Started
 * Edit `code/Data/Configuration.php` and update with the appropriate strings for your installation.
 * Use the schema in `code/schema.sql` to create the database.
 * Ensure the web user has the ability to manipulate files & folders in the published site directory.
 * That's pretty much it.

# Issues You Should Know About
 * Understand the nature of this software -- it was written during a caffiene fueled bender. There will absolutely be bugs, security issues, etc.
 * The documentation was written on a plane a couple of months after we finished (and WON!) the hackathon. My recollection is not perfect.
 * This should absolutely only be used as a reference object.
