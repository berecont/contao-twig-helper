# contao-twig-helper  
## RSCE  

### Bilder
```
'image' => [
    'label' => ['Bild','ein Standortbild auswählen'],
    'inputType' => 'fileTree',
    'eval' => [
        'tl_class' => 'clr',
        'fieldType' => 'radio',
        'filesOnly' => true,
        //'extensions' => \Contao\Config::get('validImageTypes'),
        'extensions' => '%contao.image.valid_extensions%',
        'mandatory' => true,
    ],
],  
```
als background-image:  
`style="background-image:url({{ figure(image, {}).image.img.src }})"`  

als `<figure>` aus einer Liste `'inputType' => 'list'`:  
```
{% for package in packages %}
  {% set options = {} %}
  {% set figure = contao_figure(package.image, options) %}
  {{ figure|raw }}
{% endfor %}
```
oder wenn `size` mit im Backend definiert ist:  
```
{% for package in packages %}
  {% set options = {} %}
  {% set figure = contao_figure(package.image, size, options) %}
  {{ figure|raw }}
{% endfor %}
```

wenn als Variable z.b. `myText` bereit gestellt wird, der als `<figcaption>` befüllt werden soll:  
[siehe auch Contao Doku - Image Studio](https://docs.contao.org/dev/framework/image-processing/image-studio/)
```
{% set options = {
    metadata: { caption: myText }
} %}
{% set figure = contao_figure(singleSRC, size, options) %}
{{ figure|raw }}
```

### Übersetzungen  
[Contao Forum](https://community.contao.org/de/showthread.php?86761-rsce_mytemplate-html-twig-%C3%9Cbersetzung-ausgeben)  
```
'types' => [
    'label' => ['Art der Werbung','die Art der Werbung auswählen'],
    'inputType' => 'select',
    'eval' => [
        'tl_class' => 'w50',
    ],
    'options' => [
        'offline-transparent',
        'online-digital-signage',
        'online-transparent',
        'social-media',
    ],
    'reference' => &$GLOBALS['TL_LANG']['MSC']['promotype'],
],
```
für die Backendanzeige: `/contao/languages/de/default.php`  
```
<?php

$GLOBALS['TL_LANG']['MSC']['promotype'] = [
    'offline-transparent' => 'Transparentwerbung',
    'online-digital-signage' => 'Digital Signage',
    'online-transparent' => 'Online Transparentwerbung',
    'social-media' => 'Social Media',
];
```
für die Ausgabe im Frontend: `/contao/languages/de/default.xlf`   
```
<?xml version="1.0" ?><xliff version="1.1">
    <file datatype="php" original="src/Resources/contao/languages/en/default.php" source-language="en" target-language="de">
        <body>

            <trans-unit id="MSC.offline-transparent">
                <source>types.offline-transparent</source>
                <target>Transparentwerbung</target>
            </trans-unit>        
            <trans-unit id="MSC.online-digital-signage">
                <source>types.online-digital-signage</source>
                <target>Digital Signage</target>
            </trans-unit>  
            <trans-unit id="MSC.online-transparent">
                <source>types.online-transparent</source>
                <target>Online Transparentwerbung</target>
            </trans-unit>      
            <trans-unit id="MSC.social-media">
                <source>types.social-media</source>
                <target>Social Media</target>
            </trans-unit>              

        </body>
    </file>
</xliff>
```
Ausgabe im Frontend aus einer Liste `'inputType' => 'list'`:  
```
<p class="text">{{ ('MSC.' ~ package.types)|trans({}, 'contao_default') }}</p>
```

### Dateipfad auslesen  
siehe `/templates/theme/rsce_packagelist.html.twig` und `/src/Twig/AppExtension.php`  

### Insert Tags ausgeben  
```
<p>{{ insert_tag('page::title') }}</p>
```
oder für Email (mit der Variablen 'email'):  
```
<p>{{ insert_tag('email::' ~ email) | raw }}</p>
```
weiters kann die erzeugte Klasse mit befüllt werden:  
```
{% set emailLink = insert_tag('email::' ~ email) %}
{{ emailLink | replace({'class="email"': 'class="email text-dark"'}) | raw }}
```

### Leerzeichen vermeiden und hinzufügen  
```
<div class="hero-thumb1{{ thumbclassLeft is not empty ? ' ' ~ thumbclassLeft : '' }}"
```
In diesem Beispiel prüft der Ausdruck, ob `thumbclassLeft` nicht leer ist (`thumbclassLeft is not empty`). Wenn das der Fall ist, wird ein Leerzeichen (`' '`) hinzugefügt und dann der Wert von `thumbclassLeft`. Wenn die Variable leer ist, wird einfach ein leerer String (`''`) verwendet.  
Das sorgt dafür, dass im HTML `class="hero-thumb1 thumbclassLeft"` ausgegeben wird, wenn `thumbclassLeft` gesetzt ist, und nur `class="hero-thumb1"` wenn nicht.  


  
### Verlinkungen  
Abfragen, ob eine ausgewählte URL ein interner oder externer Link ist.  
```
{% for set in iconsets %}
{% set isExternal = set.url starts with 'http' %}
    <a href="{{ set.url|raw }}" {% if isExternal %}target="_blank" rel="noopener noreferrer"{% endif %}><span class="bi">&#x{{ set.icon|raw }}</span></a>
{% endfor %}
```
Hier wird (in der for-Schleife) abgefragt, ob die URL mit einem `http` beginnt. Falls JA, wird ein `target="_blank"` und `rel="noopener noreferrer"` gesetzt.  



## Gallery
### Gallery template - Klassen in `<li>` einfügen  
```
{# templates/content_element/gallery.html.twig #}
{% extends "@Contao/content_element/gallery.html.twig" %}

{% block list_item_attributes -%}
  {%- set list = list|merge({'item_attributes': attrs().addClass('gallery-item').mergeWith(list.item_attributes|default)}) -%}
  {{ parent() }}
{%- endblock %}
```
[Contao Forum](https://community.contao.org/de/showthread.php?88193-5-3-31-Gallery-Template-anpassen&p=594568&viewfull=1#post594568)  
Unter `#5`wird auch vermerkt, warum die Variante von mir unter `#4`nicht verwendet werden sollte.  

### Bild als background-image:  
```
{% extends "@Contao/content_element/gallery.html.twig" %}

{% block list_component %}
  <ul class="custom-gallery">
    {% for item in items %}
      {% if item.image.picture.img.src is defined %}

        {% set imagePath = item.image.getImageSrc(true) %}
        <li style="background-image: url('{{ imagePath }}');"></li>
        
      {% endif %}
    {% endfor %}
  </ul>
{% endblock %}
```
siehe auch [Contao Forum](https://community.contao.org/de/showthread.php?88360-Contao-5-URL-von-Inhaltselement-Bild-finden&p=595827&viewfull=1#post595827)  


## headline eine Klasse mitgeben  
[Slack](https://contao.slack.com/archives/C040UGZL9PU/p1745586027804109?thread_ts=1745584293.195699&cid=C040UGZL9PU)  
Problem: Controller oder Extension einer anderen Anwendung darf die Anpassung nicht überschreiben oder doppelt ausgeben  
`class="..." class="..."`
```
{# templates/component/_headline.html.twig #}
{% use "@Contao/component/_headline.html.twig" %}

{% block headline_attributes -%}
    {% set headline = headline|merge({attributes: attrs().addClass('foobar').mergeWith(headline.attributes|default)}) %}
    {{ parent() }}
{%- endblock %}
```
## CE Download, dem Link eine Klasse geben  
```
{% extends "@Contao/content_element/download.html.twig" %}

{% set download_link_attributes = attrs()
    .addClass('foobar')
    .mergeWith(download_link_attributes|default)
%}
```


