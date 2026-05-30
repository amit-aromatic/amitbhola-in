1) Save the new file into `store/files/`.
2) Choose a category tag or tags for the new item.
3) Open `index.html` and find the store section near `<div class="row" id="store">`.
4) Copy an existing item block that begins with `<div class="filter_tag_0 ... store-item col-sm-12 col-xs-12 col-md-6">`.
5) Update the copied block:
   - set the `<h3>` text to the item title,
   - set `onclick="download_file('FILE_NAME')"` to the exact file name in `store/files/`,
   - update the description paragraph,
   - update the tag spans with `onclick="apply_filter(TAG_ID)"` as needed.
6) If the filter dropdown total count text says `All ( 69 )`, update that number manually to reflect the new total.
7) Save the page and verify the new download item works in the browser.