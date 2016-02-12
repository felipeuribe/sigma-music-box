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
                Seguro Desea Actualizar Este Album
            </P>
            <form action="{{url('album/edit')}}/{{album.idAlbum}}" method="post">
                <label>Nuevo Nombre del Album</label>
                <input type="text" name="name" class="form-control" id="name" value="{{album.name}}" required >
                <br>
                <label>Nuevo Numero de Pistas</label>
                <input type="text" name="numberTracks" class="form-control" id="numberTracks" value="{{album.numberTracks}}"required>
                <br>
                <label>Nuevo Año del Album</label>
                <input type="text" name="year" class="form-control" id="year" value="{{album.year}}" >
                <br>
                
                <input class="btn btn-primary" type="submit" value="Enviar">
                <a href="{{url('album/list')}}" class="btn btn-primary">Atras</a>
            </form>
        </div>
    </div>
{% endblock%}
                
           


