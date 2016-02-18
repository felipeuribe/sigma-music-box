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
               <h4>Seguro Desea Actualizar La Cancion De Nombre : <span class="label label-default">{{song.name}}</span></h4>
            </P>
            <form action="{{url('song/changeaudio')}}/{{song.idSong}}" method="post" enctype="multipart/form-data">
                
                <div class="form-group">
                  <label >Selecciona la Nueva Cancion</label>
                  <input type="file" name="song-cover" id="song-cover" >
                  <p class="help-block">Mp3.</p>
                </div>
                
                
                <a href="{{url('song/list')}}" class="btn btn-sm btn-danger"><i class="fa fa-times"> </i></a>
                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-check" {{url('song/changeaudio')}}></i>
                    
            </form>
        </div>
    </div>
{% endblock%}
                
           


