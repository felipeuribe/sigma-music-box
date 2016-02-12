{% extends "templates/template.volt" %}
{% block content %}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h1>Eliminar Artista.</h1>
            
            <hr>
        </div>
    </div>
    <div  class="row">            
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">                
            <P>
                Sí Elimina este Artista, ya no podrá recuperar los datos, también es posible que se elimine todos los
                Albúmes que tenga Asociados este Artista.
                <br>
                ¿Esta seguro que desea eliminar este Artista?
            </P>
            <a href="{{url('artist/list')}}" class="btn btn-sm btn-default ">No</a>
            <a href="{{url('artist/delete')}}/{{idArtist}}" class="btn btn-sm btn-danger">Si</a>
        </div>
    </div>
{% endblock%}

