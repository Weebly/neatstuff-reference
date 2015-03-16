# NeatStuff

This is a reference application which demonstrates usage of a few of Weebly's Cloud for Host APIs.
NeatStuff was written during an internal hackathon in late December 2014 by...
 * Drew Richards <drew@weebly.com>
 * Dustin Doiron <dustin@weebly.com>

The concept behind this was see if it was possible to, effectively, write a moderately-featured webhost in 24 hours. (It was)

To see NeatStuff in action, you can visit http://store.neatstuffontheinternet.com.

# Requirements
 * Apache
 * PHP >= 5.6
 * PostgreSQL (written on 9.3, but will likely work on 8.0+)
 * An FTP server (we used vsftpd)

# Getting Started
 * Edit `code/Data/Configuration.php` and update with the appropriate strings for your installation.
 * Use the schema in `code/schema.sql` to create the database.
 * Use the Apache configuration in `code/apache.conf`, updating it to point to your desired base publish directory.
 * Create a symlink in your base publish directory, or otherwise make `themes.yourdomain.com` point to `/themes` in this project.
 * Add your theme zip files to `code/Util/BaseTemplates` and run `code/Util/importThemes.php` (see the example template, and documentation in `importThemes.php` for details).
 * Ensure the web user has the ability to manipulate files & folders in the published site directory.
 * You're done!

# Issues You Should Know About
 * Understand the nature of this software -- it was written during a caffiene fueled bender. There will absolutely be bugs, security issues, etc.
 * The documentation was written on a plane a couple of months after we finished (and WON!) the hackathon. My recollection is not perfect.
 * This should absolutely only be used as a reference object.
