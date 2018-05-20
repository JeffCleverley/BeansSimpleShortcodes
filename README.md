# Beans Simple Shortcodes

Plugin to add the simple shortcodes for displaying theme and post information easily.  

#### All shortcodes:

- Output html content and markdown using Beans HTML API functions.  
- Have shortcode default and output filters.
- Can be enabled or disabled individually in the admin.

So not to load unnecessary code, each Shortcode has a checkbox on the Beans Simple Shortcodes settings page to disable the shortcode and not load its PHP function. Beans is fast, these shortcodes shouldn't slow it down!

Very much a work in progress:

Development lans:

- Load shortcodes via configuration, allow users to add other shortcodes and hook into the admin interface and enable/disable functionality.  
- Vary shortcode admin metaboxes opacity depending on enabled/disabled state.    

## Post Shortcodes include: 
(only usable on posts/post-meta areas)

#### [beans_date_posted]

Shortcode to display the date a post was published inside a &lt;span&gt; element.  

Supported attributes are:  

before          - Displayed before the date posted (defaults to empty string).  
after           - Displayed after the date posted (defaults to empty string).  
class           - Additional classes to add to the span element (defaults to empty string).  
style           - Inline CSS styling to add to the span element (defaults to empty string).  
date-format     - Date format (defaults to current WordPress setting).   

Acceptable date formats can be found here: https://codex.wordpress.org/Formatting_Date_and_Time  

#### [beans_date_updated]

Shortcode to display the date a post was last updated inside a &lt;span&gt; element.  

Supported attributes are:  

before          - Displayed before the date posted (defaults to empty string).  
after           - Displayed after the date posted (defaults to empty string).  
class           - Additional classes to add to the span element (defaults to empty string).  
style           - Inline CSS styling to add to the span element (defaults to empty string).  
date-format     - Date format (defaults to current WordPress setting).  

Acceptable date formats can be found here: https://codex.wordpress.org/Formatting_Date_and_Time  

#### [beans_time_posted]

Shortcode to display the time a post was published inside a &lt;span&gt; element.  

Supported attributes are:  

before          - Displayed before the date posted (defaults to empty string).  
after           - Displayed after the date posted (defaults to empty string).  
class           - Additional classes to add to the span element (defaults to empty string).  
style           - Inline CSS styling to add to the span element (defaults to empty string).   
time-format     - Time format (defaults to current WordPress setting).    

Acceptable Time formats can be found here: https://codex.wordpress.org/Formatting_Date_and_Time  

#### [beans_time_updated]

Shortcode to display the time a post was last updated inside a &lt;span&gt; element.  

Supported attributes are:  

before          - Displayed before the date posted (defaults to empty string).   
after           - Displayed after the date posted (defaults to empty string).   
class           - Additional classes to add to the span element (defaults to empty string).  
style           - Inline CSS styling to add to the span element (defaults to empty string).  
time-format     - Time format (defaults to current WordPress setting).   

Acceptable Time formats can be found here: https://codex.wordpress.org/Formatting_Date_and_Time  

#### [beans_post_author]

Shortcode that displays the unlinked post author's name inside a &lt;span&gt; element.  

Supported attributes are:  

before=         - Displayed before the post author's name (defaults to 'By ').   
after=          - Displayed after the post author's name (defaults to empty string).     
class           - Additional classes to add to the span element (defaults to empty string).    
style           - Inline CSS styling to add to the span element (defaults to empty string).    

#### [beans_post_author_link]

Shortcode that displays the post author's name as a link inside a &lt;span&gt; element.   

Supported attributes are:  

before      - Displayed before the post author link (defaults to 'By ').    
after       - Displayed after the post author link (defaults to empty string).     
span-class  - Additional classes to add to the span element (defaults to empty string).    
span-style  - Inline CSS to style the span element (defaults to empty string).    
link-class  - Additional classes to add to the anchor link element (defaults to empty string).    
link-style  - Inline CSS to style the anchor link element (defaults to empty string).    

#### [beans_post_comments]

Shortcode that displays a link to the current post's comments inside a &lt;span&gt; element.  

Supported attributes are:  

before          - Displayed before the link to the post comments (defaults to empty string).   
after           - Displayed after the link to the post comments (defaults to empty string).   
span-class      - Additional classes to add to the span element (defaults to empty string).   
span-style      - Inline CSS to style the span element (defaults to empty string).   
link-class      - Additional classes to add to the anchor link element (defaults to empty string).   
link-style      - Inline CSS to style the anchor link element (defaults to empty string).    
no-comments     - Text when there are no comments (defaults to 'Leave a comment').   
one-comment     - Text when there is one comment (defaults to '1 comment').   
more-comments   - Text when there are multiple comments (defaults to '%s comments').    

#### [beans_post_tags]

Shortcode that displays the post tag links inside a &lt;span&gt; element.  

Supported attributes are:  

before  - Displayed before the tag link list (defaults to 'Tagged with: ').   
after   - Displayed after the tag link list (defaults to empty string).   
sep     - Displayed between items in the tag list (defaults to ', ').   
class   - Additional classes to add to the span element (defaults to empty string).    
style   - Inline CSS styling to add to the span element (defaults to empty string).    

#### [beans_post_categories]

Shortcode that displays the categories links list inside a &lt;span&gt; element.  

Supported attributes are:  

before  - Displayed before the category link list (defaults to 'Filed under: ').   
after   - Displayed after the category link list (defaults to empty string).   
sep     - Displayed between items in the category list (defaults to ', ').   
class   - Additional classes to add to the span element (defaults to empty string).     
style   - Inline CSS styling to add to the span element (defaults to empty string).     

#### [beans_post_terms]

Shortcode that displays a linked list of taxonomy terms for the post inside a &lt;span&gt; element.   

Supported attributes are:   

before      - Displayed before the taxonomy terms link list (defaults to 'Filed under: ').   
after       - Displayed after the taxonomy terms link list (defaults to empty string).    
sep         - Separator displayed between items in the list (defaults to ', ').    
taxonomy    - Name of the taxonomy to display (defaults to 'category').    
class       - Additional classes to add to the span element (defaults to empty string).     
style       - Inline CSS styling to add to the span element (defaults to empty string).     

#### [beans_post_edit]

Shortcode that displays the edit post link inside a &lt;span&gt; element.    

Supported attributes are:    

before      - Displayed before the post edit link (defaults to empty string).    
after       - Displayed after the post edit link (defaults to empty string).  
span-class  - Additional classes to add to the span element (defaults to empty string).    
span-style  - Inline CSS to style the span element (defaults to empty string).    
link-class  - Additional classes to add to the anchor link element (defaults to empty string).     
link-style  - Inline CSS to style the anchor link element (defaults to empty string).      
link        - Link text to be displayed (defaults to '(Edit)').    

## General Shortcodes include:
(can be used anywhere - footer etc)

#### [beans_copyright]

Shortcode that adds a visual copyright notice inside a &lt;span&gt; element.     

Supported attributes are:    

before      - Displayed before the Copyright notice (defaults to empty string).    
after       - Displayed after the Copyright notice (defaults to empty string).    
copyright   - Copyright character (defaults to ©).    
first-year  - The year copyright first applies (defaults to empty string).    
class       - Additional classes to add to the span element (defaults to empty string).     
style       - Inline CSS styling to add to the span element (defaults to empty string).     

#### [beans_childtheme_link]

Shortcode that adds a link to the child theme inside a &lt;span&gt; element.     

Supported attributes are:   

before              - Displayed before the date (defaults to empty string).    
after               - Displayed after the date (defaults to empty string).    
span-class          - Additional classes to add to the span element (defaults to empty string).    
span-style          - Inline CSS to style the span element (defaults to empty string).    
link-class          - Additional classes to add to the anchor link element (defaults to empty string).     
link-style          - Inline CSS to style the anchor link element (defaults to empty string).      
child-theme-name    - Name of the child theme (defaults to defined CHILD_THEME_NAME).    
child-theme-url     - URL of the child theme (defaults to defined CHILD_THEME_NAME).    

If CHILD_THEME_NAME and CHILD THEME URL are not defined shortcode is disabled, but they may be overridden in the attributes.  


#### [beans_theme_link]

Shortcode that adds a link to the Beans Theme Framework inside a &lt;span&gt; element.   

Supported attributes are:   

before      - Displayed before the theme Beans framework link (defaults to empty string).    
after       - Displayed after the theme Beans framework link (defaults to empty string).   
span-class  - Additional classes to add to the span element (defaults to empty string).    
span-style  - Inline CSS to style the span element (defaults to empty string).    
link-class  - Additional classes to add to the anchor link element (defaults to empty string).     
link-style  - Inline CSS to style the anchor link element (defaults to empty string).        
beans       - Name of the Beans theme framework (defaults to 'Beans').    
beans-url   - URL of the Beans theme framework (defaults to 'https://getbeans.io').    


#### [beans_wordpress_link]

Shortcode that adds a link to WordPress.org inside a &lt;span&gt; element.   

Supported attributes are:  

before          - Displayed before the WordPress.org link (defaults to empty string).   
after           - Displayed after the WordPress.org link (defaults to empty string).   
span-class      - Additional classes to add to the span element (defaults to empty string).    
span-style      - Inline CSS to style the span element (defaults to empty string).    
link-class      - Additional classes to add to the anchor link element (defaults to empty string).     
link-style      - Inline CSS to style the anchor link element (defaults to empty string).      
wordpress       - WordPress, the one and only (defaults to 'WordPress').    
wordpress-url   - URL of WordPress.org (defaults to 'https://wordpress.org').    

#### [beans_site_title]

Shortcode displays the unlinked site title inside a &lt;span&gt; element.    

Supported attributes are:    

before  - Displayed before the site title (defaults to empty string).    
after   - Displayed after the site title (defaults to empty string).   
class   - Additional classes to add to the span element (defaults to empty string).      
style   - Inline CSS styling to add to the span element (defaults to empty string).      

#### [beans_home_link]

Shortcode displays a link to the home page inside a &lt;span&gt; element.    

Supported attributes are:    

before      - Displayed before the homepage link (defaults to empty string).    
after       - Displayed after the homepage link (defaults to empty string).   
span-class  - Additional classes to add to the span element (defaults to empty string).    
span-style  - Inline CSS to style the span element (defaults to empty string).    
link-class  - Additional classes to add to the anchor link element (defaults to empty string).     
link-style  - Inline CSS to style the anchor link element (defaults to empty string).      

#### [beans_loginout]

Shortcode displays an admin login/logout link inside a &lt;span&gt; element.   

Supported attributes are:  

before-login    - Displayed before the login link (defaults to empty string).   
after-login     - Displayed after the login link (defaults to empty string).    
before-logout   - Displayed before the logout link (defaults to empty string).    
after-logout    - Displayed after the logout link (defaults to empty string).    
login-text      - The login link text (defaults is 'login').    
logout-text     - The logout link text (defaults to 'logout').    
login-redirect  - Page to redirect to after login (defaults to empty string).    
logout-redirect - Page to redirect to after logout (defaults is homepage via home_url() ).   
span-class      - Additional classes to add to the span element (defaults to empty string).    
span-style      - Inline CSS to style the span element (defaults to empty string).    
link-class      - Additional classes to add to the anchor link element (defaults to empty string).     
link-style      - Inline CSS to style the anchor link element (defaults to empty string).      

