{% extends "templates/template.volt" %}
{% block content %}
    <div  class="row">
        <div class="col-md-12">
            <h1>Ingresar Un Nuevo Artista</h1>
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
            <form action="{{url('artist/new')}}" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="name">Nombre del Artista</label>
                  <input type="text" name="name" class="form-control" id="name" placeholder="Nombre del artista" required>
                </div>
                
                <div class="form-group">
                  <label for="name">Digite El Pais Del Artista</label>
                  <input type="text" name="country" class="form-control" id="country" placeholder="Pais Del Artista" required>
                </div> 
                
                <div class="form-group">
                    <label for="name">Seleccione Los Generos Del Artista</label>
                    <select multiple name="genders[]" class="form-control">
                        {% for gender in genders %}
                            <option value="{{gender.idGender}}">{{gender.name}}</option>
                        {% endfor %}
                    </select>
                </div>  
                    
                <div class="form-group">
                    <label for="artist-cover">Selecciona la imagen del Artista</label>
                    <input type="file" name="artist-cover" id="artist-cover" required>
                    <p class="help-block">Jpg.</p>                    
                </div>             
               
                <a href="{{url('artist/list')}}" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>
                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-check"></i></button>                          
            </form>  
        </div>
    </div>
{% endblock  %}

