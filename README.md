# Draupnr
Draupnr regularly crafts static sites from dynamic templates based on complex data inputs.
  
Serving a folder full of html files will always be orders of magnitude faster than any dynamic, scripted site. It also requires orders of magnitude less in resources and thereby cost.  
  
But, it is hard to modify content on large sites with hundreds of pages, when the pages are all static. Nonetheless, we go to incredible lengths to simulate the speed of static pages through elaborate caching schemes. There are entire industries built on the idea of serving static versions of dynamic sites.  
  
I have been experimenting recently with the ability to automatically, periodically fetch some data sources and then insert things into templates and generate static html files based on the data. The performance boost versus a dynamic PHP site is enormous, and the important parts can still be dynamic using JavaScript, ajax, or even PHP (ie. Facebook integration, etc.).
