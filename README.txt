To customize:

1) make a copy of this directory, and change the name to the name of your theme

2) run search & replace from "actionsite" to your new theme name in the following files:

css/editor-style.css
inc/widgets.php
comments.php
footer.php
functions.php
content.php
header.php
rtl.css
style.css

You can do this from the command line using the following:

grep -rl "actionsite" somedir/ | xargs sed -i 's/actionsite/[your-new-theme-name]/g'

3) Replace "Webskillet14_" in inc/widgets.php with capitalized version of theme name (or remove widget class definition, if you're not going to use any custom widgets)

4) Change theme name in style.css
