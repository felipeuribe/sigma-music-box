{% extends "templates/template.volt" %}
{% block content %}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h1>Eliminar Albúmes.</h1>
            <hr>
        </div>
    </div>
    <div  class="row">            
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">                
            <P>
                Sí elimina este Album, ya no podrá recuperar los datos, también es posible que no pueda
                eliminarlo si esta relacionado con una Cancion.
                <br>
                ¿Esta seguro que desea eliminar este Artista?
            </P>
            <a href="{{url('album/list')}}" class="btn btn-sm btn-default ">No</a>
            <a href="{{url('album/delete')}}/{{idAlbum}}" class="btn btn-sm btn-danger">Si</a>
        </div>
    </div>
{% endblock%}

