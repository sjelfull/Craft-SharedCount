## Craft SharedCount plugin

Use [SharedCount.com](http://www.sharedcount.com/) to fetch statistics about shares/likes the following services in one call:

- Facebook 
- Twitter
- Pinterest
- LinkedIn
- StumbleUpon
- Google+

### Usage

```
{% set stats = craft.sharedcount.likes({
    url: 'http://google.com'
}) %}

<ul>
{% for service,count in stats %}
    {% if count is iterable %}
        <li>{{ service }}
        <ul>
            
        {% for key,value in count %}
            <li>{{ key }}: {{ value }}</li>
        {% endfor %}
        </ul>
        </li>
    {% else %}
        <li>{{ service }}: {{ count ? count : 0 }}</li>
    {% endif %}
{% endfor %}
</ul>
```