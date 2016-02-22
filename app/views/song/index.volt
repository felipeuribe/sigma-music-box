{% extends "templates/template.volt" %}
{% block content %}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h1>Listado de Canciones.</h1>
            <hr>
        </div>
    </div>    
        
        
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <br>
            {{flashSession.output()}}
        </div>
    </div>    
        
    <div class="row">            
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="table-responsive"> 
                <table class="table"> 
                    <thead> 
                        <tr>                                  
                            <th>ID </th> 
                            <th>Nombre</th> 
                            <th>Nombre Del Album</th> 
                            <th>Numero</th>                            
                            <th>Duración</th>
                            <th>Cancion</th>
                            
                        </tr> 
                    </thead> 
                    <tbody>
                {% for song in song %}
                        <tr> 
                            <td>{{song.idSong}}</td> 
                            <td><strong> {{song.name}}</strong></td> 
                            <td>
                                 {% for album in albums %}
                                    {% if album.idAlbum == song.idAlbum %}
                                        {{album.name}} <br>
                                    {% endif %}    
                                {% endfor %}  

                            </td> 
                            <td>{{song.number}}</td> 
                            
                            <td>{{song.duration}}</td> 
                            <td>
                                 <audio controls>
                                <source src="{{url('')}}/assets/music/{{song.idAlbum}}/{{song.idSong}}.mp3" type="audio/mpeg">
                                </audio>
                            </td>
                            
                        </tr>
                {% endfor %}
                    </tbody> 
                </table> 
            </div>
        </div>
    </div>
{% endblock %}
                     