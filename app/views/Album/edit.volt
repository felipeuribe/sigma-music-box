{% extends "templates/template.volt" %}
{% block content %}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h1>Actualizar El Album.</h1>
            <hr>
        </div>
    </div>
    
    <div  class="row"> 
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
            {{flashSession.output()}}
        </div>
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
            
            <P>
                <h4>Seguro Desea Actualizar Los Datos Del Albúm <span class="label label-default">{{album.name}}</span></h4>
            </P>
            <form action="{{url('album/edit')}}/{{album.idAlbum}}" method="post">
                
                <div class="form-group">
                    <label for="name">Seleccione El Nuevo Artista</label>
                    <select  name="artist" class="form-control">
                        <option>Seleccionar...</option>                        
                        {% for artist in artists %}
                            <option value="{{artist.idArtist}}" 
                                    {% if artist.idArtist == album.idArtist%}selected {% endif %}>
                                    {{artist.name}}
                            </option>
                        {% endfor %}                        
                    </select>
                </div>                    
                   
                <label>Nuevo Nombre del Album</label>
                <input type="text" name="name" class="form-control" id="name" value="{{album.name}}" required >
                <br>                
                <label>Nuevo Año del Album</label>
                <input type="text" name="year" class="form-control" id="year" value="{{album.year}}" >
                <br>
                
                <a href="{{url('album/list')}}" class="btn btn-sm btn-danger"><i class="fa fa-times"> </i></a>
                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-check" {{url('album/edit')}}></i>
                
                
            </form>
        </div>
    </div>
{% endblock%}
                
           


