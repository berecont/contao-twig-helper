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






