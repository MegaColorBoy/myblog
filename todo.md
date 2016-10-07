# To-do list
### This list is to keep track of my current progress.
#### Reference:

> - [x] completed
> - [ ] incomplete

# Basic user functionality:
- [x] header.php
- [x] header2.php
- [x] footer.php
- [x] index.php
- [x] login.php
- [x] logout.php
- [x] users.php (a.k.a view users)
- [x] add_user.php
- [x] edit_user.php (only for the ones using it, can't change other users details.)
- [x] delete_user.php
- [x] me.php

# Subscribers:
- [x] subscribers.php
- [x] delete-subscriber.php
- [x] add-subscriber.php (just for test but this feature will be added to the
client page though.)
- [ ] send-mail.php
- [ ] send-mail-to-all.php

# Mail class:
- [ ] mail.php (class)
- [ ] mail_templates.php (class)

# Links:
- [x] links.php
- [x] add-link.php
- [x] edit-link.php
- [x] delete-link.php

# Images:
- [x] images.php
- [x] add-image.php (created this functionality as a Modal within images.php)
- [x] delete-image.php
- [x] download-image.php (not for me but very useful if I want to download an image from a URL and store it on my DB) -> Created as a modal within
	images.php

# Users:
- [x] users.php
- [x] add-user.php
- [x] edit-user.php
- [x] delete-user.php

# Posts:
- [x] posts.php
- [x] add-post.php
- [x] edit-post.php
- [x] delete-post.php

# Categories:
- [x] categories.php
- [x] add-category.php
- [x] edit-category.php
- [x] delete-category.php

# Feedback:
- [ ] feedback.php
- [ ] reply-feedback.php
- [ ] delete-feedback.php
- [ ] message-read.php

# Comments:
- [x] comments.php (will be implemented after posts.php)
- [x] add-comments.php (for client side, can be built for testing purposes also)
- [x] delete-comments.php

# Comments in the post:
> the comment system files are split into parts:
	* comment_box.php
	* add_comment.php
	* the script for comment_box at includes/footer.php
	* comments.css

- [x] js for comment box (can be found in includes/footer.php)
- [x] comment-box.php
- [x] comment.css
- [x] add-comment.php


# Page count:
- [ ] Display page count in CMS

# Functionality for Blog index page (myblog/index.php):
- [x] Usage of SEO friendly URLs (need to modify in .htaccess file - leave it to the last before hosting)
- [x] Generate all posts in descending order
- [x] A page that displays posts by categories (I'll call this "category/whatever-category")
- [x] A page to view the post via simple url routing (I'll call this "view-post")
- [x] Display comments on "view-post"
- [x] Display related posts on "view-post"
- [x] Display archives
- [x] Display all my links
- [ ] Allow people to subscribe - might scrape it off or implement it later
- [ ] Visitors are able to send feedback/queries to me