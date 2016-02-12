{% extends "templates/template.volt" %}
{% block content %}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h1>Actualizar La Imagen Del Album.</h1>
            <hr>
        </div>
    </div>   
    
    <div  class="row"> 
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
            
            {{flashSession.output()}}
        </div>        
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">                
            <P>
                Seguro Desea Actualizar La Imagen Del album
            </P>
            <form action="{{url('album/changeimage')}}/{{album.idAlbum}}" method="post" enctype="multipart/form-data">
                
                <div class="form-group">
                  <label >Selecciona la Nueva Imagen Del Album</label>
                  <input type="file" name="album-cover" id="artist-cover" >
                  <p class="help-block">Jpg.</p>
                </div>
                
                
                <a href="{{url('album/list')}}" class="btn btn-sm btn-danger"><i class="fa fa-times"> </i></a>
                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-check" {{url('album/changeimage')}}></i>
                    
            </form>
        </div>
    </div>
{% endblock%}
                
           


