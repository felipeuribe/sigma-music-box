{% extends "templates/template.volt" %}
{% block content %}  
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h1>Listado de Artistas.</h1>
            <hr>
        </div>
    </div> 
    <div class="row">
        <br>
        {% for artist in artist %}
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-center">
                <img class="album-cover" src="{{url('')}}assets/artists/images/{{artist.idArtist}}/{{artist.idArtist}}.jpg"> 
                <div class="artist-name ">
                    <strong> {{artist.name}}</strong>
                </div>                
            </div>      
        {% endfor %}        
    </div> 
{% endblock %}
