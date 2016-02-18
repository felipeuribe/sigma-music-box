{% extends "templates/template.volt" %}
{% block content %}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h1>Eliminar Cancion.</h1>
            <hr>
        </div>
    </div>
    <div  class="row">            
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">                
            <P>
                Sí elimina esta Cancion, ya no podrá recuperar los datos
                <br>
                ¿Esta seguro que desea eliminar esta Cancion?
            </P>
            <a href="{{url('song/list')}}" class="btn btn-sm btn-default ">No</a>
            <a href="{{url('song/delete')}}/{{idSong}}" class="btn btn-sm btn-danger">Si</a>
        </div>
    </div>
{% endblock%}

