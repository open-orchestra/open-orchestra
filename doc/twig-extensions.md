# TWIG EXTENSIONS #
----------

PHPOrchestra comes with several new twig functions. Here is a small doc about them.

##### 1. phpOrchestra Themes
phpOrchestra provides two functions to add all css and js html tags related to a theme in a single call. These functions are phpOrchestraCss and phpOrchestraJs.

A theme is a set of css and js files. A theme can be put in any bundle, but must  be located in a directory of the theme name. This directory must be located under the resources/public/themes folder.

Here is a scheme describing valid themes :

	    └── CustomAppBundle
	        └── Resources
	            └── public
	                └── themes
	                    ├── MyTheme1
		                │   ├── css
		                │   │   ├── css1.css
		                │   │   └── css2.css
		                │   └── js
		                │       ├── js1.js
		                │       └── js2.js
		                │   
	                    ├── MyTheme2
		                │   ├── css1.css 
		                │   ├── css2.css
		                │   └── js.js
						│
			            └── MyTheme3
		                    ├── folder1
		                    │   ├── css1.css
		                    │   └── js1.css
		                    └── folder2
		                        └── folder3
		                        	└── js2.js



A theme is represented by a logical name formated as following : **BundleName:ThemeName**. For instance, the tree themes of the previous scheme are refered as ***CustomAppBundle:MyTheme1***, ***CustomAppBundle:MyTheme2*** and ***CustomAppBundle:MyTheme3***.

A theme is set in a config file by describing all the files it is composed by. A file is represented by the theme logical name plus the path to the file inside the theme folder. For instance, the first css of MyTheme1 is represented by ***CustomAppBundle:MyTheme1:css/css1.css***

A theme must be set as following :

	php_orchestra_theme:
    	themes: 
    	    sample: /* Theme id, must be unique */
    	        name: "Exemple" /* Theme name */
    	        stylesheets: /* array of stylesheets, optional */
    	            - PHPOrchestraThemeBundle:sample:css/master.css
    	            - PHPOrchestraThemeBundle:sample:css/fo.css
            	javascripts : /* array of javascripts, optional */
                	- PHPOrchestraThemeBundle:theme1:js/empty.js



To generate stylesheets html tags in a twig template, use the following code :

    {{ phpOrchestraCss(ThemeId) }}

and this one for javascripts files :

    {{ phpOrchestraJs(ThemeId) }}
