{% extends "templates/template.volt" %}
{% block content %}
    <div  class="row">
        <div class="col-md-12">
            <h1>Ingresar Un Nuevo Albúm</h1>
            <hr>
        </div>
    </div>
    <div  class="row">
        <div class="col-md-12">
            <br>
            {{flashSession.output()}}
        </div>
    </div>    
    <div  class="row">
        <div class="col-md-offset-3 col-md-6">
            <form action="{{url('album/new')}}" method="post" enctype="multipart/form-data">                             
                <div class="form-group">
                    <label for="name">Seleccione El Artista</label>
                    <select  name="artist" class="form-control">
                        <option>Seleccionar...</option>
                        {% for artist in artists %}                            
                            <option value="{{artist.idArtist}}">{{artist.name}}</option>
                        {% endfor %}
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="name">Nombre del Album</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Nombre del Albúm" >
                </div> 
                                    
                <div class="form-group">
                    <label for="name">Digite El Año del Albúm</label>
                    <input type="text" name="year" class="form-control" id="year" placeholder="Año Del Albúm" >
                </div>
                    
                <div class="form-group">
                    <label for="album-cover">Selecciona la imagen del Albúm</label>
                    <input type="file" name="album-cover" id="album-cover" >
                    <p class="help-block">Jpg.</p>                    
                </div>
                
                <a href="{{url('album/list')}}" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>
                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-check"></i></button>                    
                
                
                    
                 
                
            </form>  
        </div>
    </div>
{% endblock  %}

