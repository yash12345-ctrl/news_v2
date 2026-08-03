# Akhbar-e-Mashriq

## How to add multi linugal support

How I solved Urdu and Hindustani language problem in the same website.

Used cookie and header to store language preference in cient side
cookie name: `lang_pref`
header name: `X-Lang-Pref`

1. When user switches language using url (we given option for that) then
we store a small `lang_pref` cookie in the client side.
2. So every time user visits any URL we know what language he/she prefers
3. Then I changed access to `FIELD_ur` or `FIELD_en` to just `FIELD` in everywhere (views)
4. Then I created model attribute accessor in Article Model 

```php
    public function getTitleAttribute($value)
    {
        return lang_english() ? $this->title_en : $this->title_ur;
    }

    public function getContentShortAttribute($value)
    {
        return lang_english() ? $this->content_short_en : $this->content_short_ur;
    }

    public function getContentAttribute($value)
    {
        return lang_english() ? $this->content_en : $this->content_ur;
    }

```

5. I also created two global functions for checking the current request lang preference.
6. And added that global function file in composer autoload files property.  `composer dump-autoload -o`
7. Update Article Resource to also return `FIELD` without lang suffix
