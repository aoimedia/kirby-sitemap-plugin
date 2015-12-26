# Kirby Sitemap

A plugin for [Kirby](https://github.com/getkirby/starterkit) that creates an XML sitemap from all visible pages. 

If your Kirby site has multiple languages, the plugin creates the appropriate `<xhtml:link rel="alternate" hreflang="…" href="…" />` annotations for each language.

## Installation
```
site/
	plugins/
		sitemap/
			sitemap.php
```

## Usage
Open `http://yourwebsite.com/sitemap.xml` to see the sitemap. (You might need to open the dev tools in your browser to view the actual xml code.)



