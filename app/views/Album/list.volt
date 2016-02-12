{% extends "templates/template.volt" %}
{% block content %}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h1>Listado de Albumes.</h1>
            <hr>
        </div>
    </div>  
    <div class="row">     
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
            <a href="{{url('album/new')}}" class="btn btn-success">
                <i class="fa fa-plus"></i>
            </a>
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
                            <th>ID</th> 
                            <th>Nombre Del Album</th> 
                            <th>Nombre Del Artista</th> 
                            <th>Numeron De Pistas</th>
                            <th>Año de Creación</th>
                            <th>Duración </th>
                            <th>Fechas </th>
                            <th>Imagen del Albúm</th>
                            <th></th>
                        </tr>  
                    </thead> 
                    <tbody>
                {% for album in album %}
                        <tr> 
                            <td>{{album.idAlbum}}</td> 
                            <td><strong> {{album.name}}</strong></td>
                            <td>                                 
                                {% for artist in artists %}
                                    {% if artist.idArtist == album.idArtist %}
                                        {{artist.name}} <br>
                                    {% endif %}    
                                {% endfor %}                                  
                            </td>
                            <td><strong> {{album.numberTracks}}</strong></td>
                            <td><strong> {{album.year}}</strong></td>
                            <td><strong> {{album.duration}}</strong></td>
                            <td>
                                Creado el: {{date('d-M-Y  ' , album.createdon)}} 
                                <br> 
                                Actualizado el: {{date('d-M-Y  ' , album.updatedon)}}
                            </td>
                            <td>
                                <img class="album-cover-list" src="{{url('')}}assets/albumes/images/{{album.idAlbum}}/{{album.idAlbum}}.jpg">
                            </td> 
                            <td>
                                <a href="{{url('album/changeimage')}}/{{album.idAlbum}}" class="btn btn-xs btn-success">
                                    <span class="fa fa-picture-o"></span>
                                </a>
                                <a href="{{url('album/edit')}}/{{album.idAlbum}}" class="btn btn-xs btn-primary">
                                    <span class="fa fa-pencil"></span>
                                </a> 
                                <a href="{{url('album/confirm')}}/{{album.idAlbum}}" class="btn btn-xs btn-danger">
                                    <span class="fa fa-times"></span>
                                </a>
                            </td>
                        </tr>
                {% endfor %}
                    </tbody> 
                </table> 
            </div>
        </div>
    </div>
{% endblock %}
                     