{% extends "templates/template.volt" %}
{% block content %}  
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h1>Listado de Albumes de  </h1>
            <hr>
        </div>
    </div> 
    
    {% for album in albums %}            
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                        <img class="album-header-cover" src="{{url('')}}assets/albumes/images/{{album.idAlbum}}/{{album.idAlbum}}.jpg"> 
                        <div class="album-header-name ">
                            <strong> {{album.name}}</strong><br>
                        </div>           
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
                        <table class="table"> 
                            <thead> 
                                <tr>                     
                                    <th>Nombre</th>                       
                                    <th>Duración</th>
                                    <th></th>
                                </tr> 
                            </thead> 
                            <tbody>
                        {% for songs in arraySongs %}
                            {% for song in songs %}
                                {% if song.idAlbum == album.idAlbum%}
                                    <tr> 
                                        <td>{{song.number}}. {{song.name}}</td> 
                                        <td>{{song.duration}}</td>                             
                                        <td>
                                            <audio controls>
                                                <source src="{{url('')}}/assets/music/{{song.idAlbum}}/{{song.idSong}}.mp3" type="audio/mpeg">
                                            </audio>
                                        </td>
                                    </tr>
                                {% endif %}
                            {% endfor %}    
                        {% endfor %}
                            </tbody> 
                        </table>    
                    </div>
                </div>
            </div>
        </div>    
                            
        <hr>
    {% endfor %}
{% endblock %}
