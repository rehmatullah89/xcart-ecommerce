{if:getNews()}
<ul class="menu menu-list news">
 {foreach:getNews(),row}
 <li><a href="{buildURL(#news#,##,_ARRAY_(#news_id#^row.id))}">{row.title}</a></li>
 {end:}
</ul>
{else:}
No news added
{end:}