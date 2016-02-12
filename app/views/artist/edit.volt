{% extends "templates/template.volt" %}
{% block content %}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h1>Actualizar El Artista.</h1>
            <hr>
        </div>
    </div>    
    <div  class="row">            
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">                
            <P>
                Seguro Desea Actualizar Este Artista
            </P>
            <form action="{{url('artist/edit')}}/{{artist.idArtist}}" method="post" enctype="multipart/form-data">
                <label for="name">Nuevo Nombre del Artista</label>
                <input type="text" name="name" class="form-control" id="name" value="{{artist.name}}" >
                <br>    
                <label for="name">Nuevo Pais del Artista</label>
                <input type="text" name="country" class="form-control" id="country" value="{{artist.country}}" >
                <br>
                
                
                <a href="{{url('artist/list')}}" class="btn btn-sm btn-danger"><i class="fa fa-times"> </i></a>
                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-check" {{url('artist/edit')}}></i>
                    
            </form>
        </div>
    </div>
{% endblock%}
                
           


