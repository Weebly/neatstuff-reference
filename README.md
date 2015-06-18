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
 * Move and edit `code/Data/Configuration.php.template` to `code/Data/Configuration.php` and update with the appropriate strings for your installation.
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

# License
Copyright (c) 2015, Weebly
All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are met:
 * Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
 * Neither the name of Weebly nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
DISCLAIMED. IN NO EVENT SHALL Weebly, Inc BE LIABLE FOR ANY
DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
(INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
