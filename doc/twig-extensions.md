# TWIG EXTENSIONS #
----------

PHPOrchestra comes with several new twig functions. Here is a small doc about them.

##### 1. phpOrchestraTheme
This twig function allows to add all css and js html tags related to a theme in a single call.
A theme is a set of css, js and images files. A theme can be put in any bundle, but must follow some rules :  

1. all the files must be located in a directory of the theme name. This directory must be located under the resources/public/themes folder.  
2. css must be located in a subfolder named css  
3. js must be located in a subfolder named js  
4. images can be placed anywhere under the theme folder, but in an img subfolder would be a good idea

Theses directives are described in that scheme :

	    └── CustomAppBundle
	        └── Resources
	            └── public
	                └── themes
	                    ├── MyTheme1
		                │   ├── css
		                │   │   ├── master.css
		                │   │   ├── css1.css
		                │   │   └── css2.css
		                │   ├── js
		                │   │   ├── js1.js
		                │   │   └── js2.js
		                │   └── img
	                    ├── MyTheme2
			            └── MyTheme3

A theme is represented by a logical name formated as following : **BundleName:ThemeName**. For instance, the tree themes of the previous scheme are refered as ***CustomAppBundle:MyTheme1***, ***CustomAppBundle:MyTheme2*** and ***CustomAppBundle:MyTheme3***.

To generate the corresponding html tags in a twig template, use the following code :

    {{ phpOrchestraTheme('CustomAppBundle:MyTheme1') }}