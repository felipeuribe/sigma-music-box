{% extends "templates/template.volt" %}
{% block content %}  
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h1>Listado de Canciones.</h1>
            <hr>
        </div>
    </div> 
    <div class="row">
        <br>
        {% for song in song %}
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-center">
                <img class="album-cover" src="{{url('')}}assets/songs/images/{{song.idSong}}/{{song.idSong}}.jpg"> 
                <div class="album-name ">
                    <strong> {{song.name}}</strong>
                </div>                
            </div>      
        {% endfor %}        
    </div> 
{% endblock %}
