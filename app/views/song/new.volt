{% extends "templates/template.volt" %}
{% block content %}
    <div  class="row">
        <div class="col-md-12">
            <h1>Ingresar Una Nueva Canción</h1>
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
            <form action="{{url('song/new')}}" method="post" >                             
                <div class="form-group">
                    <label>Seleccione El Albúm</label>
                    <select  name="album" class="form-control">
                        <option>Seleccionar...</option>
                        {% for album in albums %}                            
                            <option value="{{album.idAlbum}}">{{album.name}}</option>
                        {% endfor %}
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="name">Nombre De La Canción</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Nombre del Albúm" required>
                </div> 
                    
                <div class="form-group">
                    <label>Digite El Numero de la Canción</label>
                    <input type="text" name="number" class="form-control" id="number" placeholder="Numero" required>
                </div>
                    
                <div class="form-group">
                    <label for="name">Digite La Duracion De La Canción</label>
                    <input type="text" name="duration" class="form-control" id="duration" placeholder="Duracion" required>
                </div> 
                <a href="{{url('song/list')}}" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>
                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-check"></i></button> 
                
            </form>  
        </div>
    </div>
{% endblock  %}

