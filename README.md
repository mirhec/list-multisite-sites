# List Multisite Sites
This wordpress plugin enables you to list all network sites that are available in your Multisite Wordpress installation.
Therefore just instert the shortcode `[list_multisite_sites]`. You can specify the `spacer` param that will be inserted
after each printed site. I.e. use `[list_multisite_sites spacer='<hr>']` to insert a horizontal line after each site.

In addition there exists another shortcode named `[list_multisite_sites_sum_cfdb]` which allows you to specify a
Contact Form 7 form and sum up a single field. This is useful if you have multiple sites with the same named CF7 form
and want to have an overview about the sum of a single field for all your Network sites. Here's an example:

```
[list_multisite_sites_sum_cfdb form_name='Your form' field_name='Your field']
```