{% extends "templates/template.volt" %}
{% block content %}  
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h1>Listado de Albumes.</h1>
            <hr>
        </div>
    </div> 
    <div class="row">
        <br>
        {% for album in album %}            
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-center">
                <img class="album-cover" src="{{url('')}}assets/albumes/images/{{album.idAlbum}}/{{album.idAlbum}}.jpg"> 
                <div class="album-name ">
                    <strong> {{album.name}}</strong><br>
                </div>                
            </div> 
                
        {% endfor %}
     
    </div> 
{% endblock %}
