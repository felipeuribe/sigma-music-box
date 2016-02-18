{% extends "templates/template.volt" %}
{% block content %}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h1>Actualizar La Cancion.</h1>
            <hr>
        </div>
    </div>
    
    <div  class="row"> 
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
            {{flashSession.output()}}
        </div>
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
            
            <P>
                <h4>Seguro Desea Actualizar Los Datos De La Cancion <span class="label label-default">{{song.name}}</span></h4>
            </P>
            <form action="{{url('song/edit')}}/{{song.idSong}}" method="post">
                
                <div class="form-group">
                    <label>Seleccione El Nuevo Album</label>
                    <select  name="album" class="form-control">
                        <option>Seleccionar...</option>                        
                        {% for album in albums %}
                            <option value="{{album.idAlbum}}" 
                                    {% if album.idAlbum == song.idAlbum%}selected {% endif %}>
                                    {{album.name}}
                            </option>
                        {% endfor %}                        
                    </select>
                </div>  

                                
                   
                <label>Nuevo Nombre de la cancion</label>
                <input type="text" name="name" class="form-control" id="name" value="{{song.name}}"  >
                <br>                
                <label>Nuevo Numero de la cancion</label>
                <input type="text" name="number" class="form-control" id="number" value="{{song.number}}" >
                <br>                
                <label>Nueva Duracion  de la Cancion</label>
                <input type="text" name="duration" class="form-control" id="duration" value="{{song.duration}}" >
                <br>
                
                <a href="{{url('song/list')}}" class="btn btn-sm btn-danger"><i class="fa fa-times"> </i></a>
                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-check" {{url('song/edit')}}></i>
                
                
            </form>
        </div>
    </div>
{% endblock%}
                
           


